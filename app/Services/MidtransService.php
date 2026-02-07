<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Snap transaction and get snap token
     * 
     * @param \App\Models\Booking $booking
     * @return string Snap token
     */
    public function createTransaction($booking)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $booking->booking_code,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->guest_name,
                'email' => $booking->guest_email,
                'phone' => $booking->guest_phone,
            ],
            'item_details' => [
                [
                    'id' => $booking->field_id,
                    'price' => (int) $booking->field->price_per_hour,
                    'quantity' => $booking->duration,
                    'name' => $booking->field->name . ' - ' . $booking->duration . ' Jam',
                ]
            ],
            'callbacks' => [
                'finish' => route('payment.callback'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create Midtrans transaction: ' . $e->getMessage());
        }
    }

    /**
     * Get transaction status from Midtrans
     * 
     * @param string $orderId
     * @return object
     */
    public function getTransactionStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            return $status;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get transaction status: ' . $e->getMessage());
        }
    }

    /**
     * Handle notification from Midtrans webhook
     * 
     * @return object Notification object
     */
    public function handleNotification()
    {
        try {
            $notification = new Notification();
            return $notification;
        } catch (\Exception $e) {
            throw new \Exception('Failed to handle notification: ' . $e->getMessage());
        }
    }

    /**
     * Verify notification signature for security
     * 
     * @param object $notification
     * @return bool
     */
    public function verifySignature($notification)
    {
        $orderId = $notification->order_id;
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $serverKey = config('midtrans.server_key');
        
        $signatureKey = $notification->signature_key ?? null;
        
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        
        return $signatureKey === $expectedSignature;
    }

    /**
     * Map Midtrans transaction status to our payment status
     * 
     * @param string $transactionStatus
     * @param string $fraudStatus
     * @return string
     */
    public function mapPaymentStatus($transactionStatus, $fraudStatus = 'accept')
    {
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                return 'paid';
            } else if ($fraudStatus == 'challenge') {
                return 'pending';
            }
        } else if ($transactionStatus == 'settlement') {
            return 'paid';
        } else if ($transactionStatus == 'pending') {
            return 'pending';
        } else if ($transactionStatus == 'deny') {
            return 'failed';
        } else if ($transactionStatus == 'expire') {
            return 'expired';
        } else if ($transactionStatus == 'cancel') {
            return 'failed';
        }

        return 'unpaid';
    }
}
