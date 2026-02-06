<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Field;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of available fields for booking
     */
    public function index()
    {
        $fields = Field::where('status', 'available')
            ->latest()
            ->get();
        
        return view('booking.index', compact('fields'));
    }

    /**
     * Show the booking form for a specific field
     */
    public function create($fieldId)
    {
        $field = Field::findOrFail($fieldId);
        
        if ($field->status !== 'available') {
            return redirect()
                ->route('booking.index')
                ->with('error', 'Lapangan sedang tidak tersedia.');
        }
        
        return view('booking.create', compact('field'));
    }

    /**
     * Check availability for AJAX request (clash detection)
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'duration' => 'required|integer|min:1',
        ]);

        $fieldId = $request->field_id;
        $date = $request->booking_date;
        $startTime = $request->start_time;
        $duration = $request->duration;
        
        // Calculate end time
        $startDateTime = Carbon::parse($date . ' ' . $startTime);
        $endDateTime = $startDateTime->copy()->addHours($duration);
        $endTime = $endDateTime->format('H:i:s');
        $startTime = $startDateTime->format('H:i:s');
        
        // Check for overlapping bookings (exclude cancelled bookings)
        $clash = Booking::where('field_id', $fieldId)
            ->where('booking_date', $date)
            ->where('booking_status', '!=', 'cancelled')
            ->where(function($query) use ($startTime, $endTime) {
                // Case 1: New booking starts during existing booking
                $query->whereBetween('start_time', [$startTime, $endTime])
                      // Case 2: New booking ends during existing booking
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      // Case 3: New booking completely overlaps existing booking
                      ->orWhere(function($q) use ($startTime, $endTime) {
                          $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                      });
            })
            ->exists();
        
        return response()->json([
            'available' => !$clash,
            'message' => $clash ? 'Jam yang dipilih sudah ada yang booking. Silakan pilih jam lain.' : 'Jam tersedia!',
        ]);
    }

    /**
     * Store a newly created booking
     */
    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();
        
        // Get field for price calculation
        $field = Field::findOrFail($validated['field_id']);
        
        // Calculate times
        $startDateTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['start_time']);
        $endDateTime = $startDateTime->copy()->addHours($validated['duration']);
        
        // Double-check availability before saving
        $clash = Booking::where('field_id', $validated['field_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where('booking_status', '!=', 'cancelled')
            ->where(function($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_time', [$startDateTime->format('H:i:s'), $endDateTime->format('H:i:s')])
                      ->orWhereBetween('end_time', [$startDateTime->format('H:i:s'), $endDateTime->format('H:i:s')])
                      ->orWhere(function($q) use ($startDateTime, $endDateTime) {
                          $q->where('start_time', '<=', $startDateTime->format('H:i:s'))
                            ->where('end_time', '>=', $endDateTime->format('H:i:s'));
                      });
            })
            ->exists();
        
        if ($clash) {
            return back()
                ->withInput()
                ->with('error', 'Maaf, jam yang Anda pilih sudah dibooking oleh orang lain. Silakan pilih jam lain.');
        }
        
        // Generate unique booking code
        $bookingCode = 'BKG' . strtoupper(Str::random(8));
        while (Booking::where('booking_code', $bookingCode)->exists()) {
            $bookingCode = 'BKG' . strtoupper(Str::random(8));
        }
        
        // Calculate total price
        $totalPrice = $field->price_per_hour * $validated['duration'];
        
        // Create booking
        $booking = Booking::create([
            'field_id' => $validated['field_id'],
            'user_id' => auth()->id(), // null if guest
            'booking_code' => $bookingCode,
            'booking_date' => $validated['booking_date'],
            'start_time' => $startDateTime->format('H:i:s'),
            'end_time' => $endDateTime->format('H:i:s'),
            'duration' => $validated['duration'],
            'guest_name' => $validated['guest_name'],
            'guest_phone' => $validated['guest_phone'],
            'guest_email' => $validated['guest_email'],
            'total_price' => $totalPrice,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'unpaid',
            'booking_status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);
        
        // Redirect to confirmation page
        return redirect()
            ->route('booking.show', $booking->booking_code)
            ->with('success', 'Booking berhasil dibuat!');
    }

    /**
     * Display booking confirmation and payment instructions
     */
    public function show($bookingCode)
    {
        $booking = Booking::with('field')
            ->where('booking_code', $bookingCode)
            ->firstOrFail();
        
        return view('booking.show', compact('booking'));
    }

    /**
     * Display customer's booking history (optional)
     */
    public function myBookings()
    {
        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login untuk melihat riwayat booking Anda.');
        }
        
        $bookings = Booking::with('field')
            ->where('user_id', auth()->id())
            ->orWhere('guest_email', auth()->user()->email)
            ->latest()
            ->paginate(10);
        
        return view('booking.my-bookings', compact('bookings'));
    }
}
