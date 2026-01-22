<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $table = 'bookings';
    protected $fillable = [
        'field_id',
        'user_id',
        'booking_code',
        'snap_token',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'booking_date',
        'start_time',
        'end_time',
        'duration',
        'guest_name',
        'guest_phone',
        'guest_email',
        'total_price',
        'payment_method',
        'payment_status',
        'booking_status',
        'notes',
        'payment_proof',
    ];
    protected $casts = [
        'booking_date' => 'date',
        // 'start_time' => 'time',
        // 'end_time' => 'time',
        'total_price' => 'decimal:2',
    ];
    public function field()
    {
        return $this->belongsTo(Field::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * BOOT METHOD (Auto generate booking code)
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'BKG' . strtoupper(Str::random(8));
            }
        });
    }
    // format harga untuk ditampilkan
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price ?? 0, 0, ',', '.');
    }

    // format tanggal untuk ditampilkan
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->booking_date)->isoFormat('D MMMM YYYY');
    }

    //   format rentang waktu untuk ditampilkan
    public function getTimeRangeAttribute()
    {
        return substr($this->start_time, 0, 5) . ' - ' . substr($this->end_time, 0, 5);
    }
    //  get customer name
    public function getCustomerNameAttribute()
    {
        return $this->user ? $this->user->name : $this->guest_name;
    }

    // get customer phone
    public function getCustomerPhoneAttribute()
    {
        return $this->user ? $this->user->phone : $this->guest_phone;
    }

    // get customer email
    public function getCustomerEmailAttribute()
    {
        return $this->user ? $this->user->email : $this->guest_email;
    }
    /**
     * Cek apakah booking ini dari guest (tanpa login)
     */
    public function isGuestBooking()
    {
        return is_null($this->user_id);
    }
    /**
     * Cek apakah booking ini dari registered user
     */
    public function isUserBooking()
    {
        return !is_null($this->user_id);
    }
    public function isUnpaid()
    {
        return $this->payment_status === 'unpaid';
    }

    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isExpired()
    {
        return $this->payment_status === 'expired';
    }

    public function isFailed()
    {
        return $this->payment_status === 'failed';
    }
    public function isBookingPending()
    {
        return $this->booking_status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->booking_status === 'confirmed';
    }

    public function isCancelled()
    {
        return $this->booking_status === 'cancelled';
    }

    public function isCompleted()
    {
        return $this->booking_status === 'completed';
    }
    public function confirm()
    {
        $this->update([
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
        ]);
    }
    public function cancel()
    {
        $this->update([
            'booking_status' => 'cancelled',
        ]);
    }
    public function complete()
    {
        $this->update([
            'booking_status' => 'completed',
        ]);
    }
    public function scopeToday($query)
    {
        return $query->whereDate('booking_date', today());
    }
    public function scopePending($query)
    {
        return $query->where('booking_status', 'pending');
    }
    public function scopeConfirmed($query)
    {
        return $query->where('booking_status', 'confirmed');
    }
    public function scopeCancelled($query)
    {
        return $query->where('booking_status', 'cancelled');
    }
    public function scopePaymentPending($query)
    {
        return $query->where('payment_status', 'pending');
    }
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }
    public function scopeByCode($query, $code)
    {
        return $query->where('booking_code', $code);
    }
}
