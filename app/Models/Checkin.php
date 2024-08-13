<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
        'reservation_code',
        'guest_name',
        'pax',
        'room_charge',
        'deposit',
        'checkin_time',
        'checkout_time',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_code', 'order_code');
    }
}
