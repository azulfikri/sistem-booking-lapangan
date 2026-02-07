<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of bookings with filters
     */
    public function index(Request $request)
    {
        $query = Booking::with(['field', 'user']);

        // Filter by payment status
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by booking status
        if ($request->filled('booking_status') && $request->booking_status !== 'all') {
            $query->where('booking_status', $request->booking_status);
        }

        // Filter by field
        if ($request->filled('field_id') && $request->field_id !== 'all') {
            $query->where('field_id', $request->field_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('booking_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('booking_date', '<=', $request->date_to);
        }

        // Search by booking code, customer name, email, or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhere('guest_phone', 'like', "%{$search}%");
            });
        }

        // Order by latest
        $bookings = $query->latest()->paginate(20);

        // Get all fields for filter dropdown
        $fields = Field::all();

        return view('admin.bookings.index', compact('bookings', 'fields'));
    }

    /**
     * Display the specified booking detail
     */
    public function show($id)
    {
        $booking = Booking::with(['field', 'user'])->findOrFail($id);
        
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,pending,paid,expired,failed',
        ]);

        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->payment_status;
        $booking->payment_status = $request->payment_status;
        
        // Auto-confirm booking when payment is confirmed
        if ($request->payment_status === 'paid' && $booking->booking_status === 'pending') {
            $booking->booking_status = 'confirmed';
        }
        
        $booking->save();

        return redirect()
            ->back()
            ->with('success', "Status pembayaran berhasil diubah dari {$oldStatus} ke {$request->payment_status}!");
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'cancel_reason' => 'required_if:booking_status,cancelled',
        ]);

        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->booking_status;
        $booking->booking_status = $request->booking_status;
        
        if ($request->booking_status === 'cancelled' && $request->filled('cancel_reason')) {
            $booking->notes = ($booking->notes ? $booking->notes . "\n\n" : '') . 
                             "Dibatalkan: " . $request->cancel_reason;
        }
        
        $booking->save();

        return redirect()
            ->back()
            ->with('success', "Status booking berhasil diubah dari {$oldStatus} ke {$request->booking_status}!");
    }

    /**
     * Cancel/Delete booking
     */
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->booking_status = 'cancelled';
        $booking->notes = ($booking->notes ? $booking->notes . "\n\n" : '') . 
                         "Dibatalkan oleh admin: " . $request->reason;
        $booking->save();

        return redirect()
            ->route('admin.bookings')
            ->with('success', 'Booking berhasil dibatalkan!');
    }
}
