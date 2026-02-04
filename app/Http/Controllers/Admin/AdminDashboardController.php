<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics
     */
    public function index()
    {
        // Revenue: Total dari booking dengan payment_status 'paid'
        $revenue = Booking::where('payment_status', 'paid')
            ->sum('total_price');

        // Bookings: Jumlah booking hari ini
        $todayBookings = Booking::whereDate('booking_date', today())
            ->count();

        // Fields: Jumlah lapangan dengan status 'available'
        $availableFields = Field::where('status', 'available')
            ->count();

        // Customers: Hitung jumlah unik guest_email dari bookings
        // Karena menggunakan Guest Booking system
        $uniqueCustomers = Booking::distinct('guest_email')
            ->count('guest_email');

        // Data tambahan untuk dashboard (optional)
        $recentBookings = Booking::with(['field'])
            ->latest()
            ->take(10)
            ->get();

        $pendingBookings = Booking::where('booking_status', 'pending')
            ->count();

        return view('admin.dashboard', compact(
            'revenue',
            'todayBookings',
            'availableFields',
            'uniqueCustomers',
            'recentBookings',
            'pendingBookings'
        ));
    }
}
