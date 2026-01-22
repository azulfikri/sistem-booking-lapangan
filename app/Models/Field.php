<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    //
    protected $table = 'fields';
    protected $fillable = [
        'name',
        'price_per_hour',
        'description',
        'photo',
        'status',
    ];
    protected $casts = [
        'price_per_hour' => 'decimal:2',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price_per_hour ?? 0, 0, ',', '.');
    }
    public function isAvailable()
    {
        return $this->status === 'available';
    }
    public function isMaintenance()
    {
        return $this->status === 'maintenance';
    }
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }
}
