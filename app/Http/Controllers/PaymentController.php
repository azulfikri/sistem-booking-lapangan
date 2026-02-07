<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Process payment - generate snap token and show payment page
     */
    public function processPayment($bookingCode)
    {
        $booking = Booking::with('field')
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        // Only allow midtrans payment method
        if ($booking->payment_method !== 'midtrans') {
            return redirect()
                ->route('booking.show', $bookingCode)
                ->with('error', 'Metode pembayaran tidak sesuai.');
        }

        // Only allow unpaid or pending status
        if (!in_array($booking->payment_status, ['unpaid', 'pending'])) {
            return redirect()
                ->route('booking.show', $bookingCode)
                ->with('error', 'Pembayaran sudah diproses.');
        }

        try {
            // Generate snap token if not exists
            if (!$booking->snap_token) {
                $snapToken = $this->midtransService->createTransaction($booking);
                
                $booking->snap_token = $snapToken;
                $booking->payment_status = 'pending';
                $booking->save();
            }

            return view('payment.process', [
                'booking' => $booking,
                'snapToken' => $booking->snap_token,
                'clientKey' => config('midtrans.client_key'),
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans payment error: ' . $e->getMessage());
            
            return redirect()
                ->route('booking.show', $bookingCode)
                ->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Handle callback from Midtrans after payment
     */
    public function callback(Request $request)
    {
        $orderId = $request->order_id ?? $request->get('order_id');
        
        if (!$orderId) {
            return redirect()->route('home')->with('error', 'Invalid payment callback.');
        }

        $booking = Booking::where('booking_code', $orderId)->first();
        
        if (!$booking) {
            return redirect()->route('home')->with('error', 'Booking tidak ditemukan.');
        }

        // Redirect to booking detail page
        return redirect()
            ->route('booking.show', $booking->booking_code)
            ->with('success', 'Terima kasih! Status pembayaran Anda sedang diproses.');
    }

    /**
     * Handle webhook notification from Midtrans
     */
    public function webhook(Request $request)
    {
        try {
            $notification = $this->midtransService->handleNotification();
            
            // Verify signature
            if (!$this->midtransService->verifySignature($notification)) {
                Log::warning('Invalid Midtrans signature');
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? 'accept';
            $paymentType = $notification->payment_type ?? null;

            Log::info('Midtrans notification received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
            ]);

            // Find booking
            $booking = Booking::where('booking_code', $orderId)->first();
            
            if (!$booking) {
                Log::warning('Booking not found for order: ' . $orderId);
                return response()->json(['message' => 'Booking not found'], 404);
            }

            DB::beginTransaction();
            try {
                // Map transaction status to payment status
                $paymentStatus = $this->midtransService->mapPaymentStatus($transactionStatus, $fraudStatus);
                
                // Update booking
                $booking->payment_status = $paymentStatus;
                $booking->midtrans_transaction_id = $notification->transaction_id ?? null;
                $booking->midtrans_payment_type = $paymentType;

                // Auto-confirm booking if payment is successful
                if ($paymentStatus === 'paid' && $booking->booking_status === 'pending') {
                    $booking->booking_status = 'confirmed';
                }

                $booking->save();

                DB::commit();

                Log::info('Booking updated successfully', [
                    'booking_code' => $orderId,
                    'payment_status' => $paymentStatus,
                    'booking_status' => $booking->booking_status,
                ]);

                return response()->json(['message' => 'OK'], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to update booking: ' . $e->getMessage());
                return response()->json(['message' => 'Failed to update booking'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Webhook processing error: ' . $e->getMessage());
            return response()->json(['message' => 'Webhook processing failed'], 500);
        }
    }
}
