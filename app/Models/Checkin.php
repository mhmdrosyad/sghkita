<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
        'reservation_code',
        'guest_name',
        'instansi',
        'total_tagihan',
        'checkin_time',
        'checkout_time',
        'status',
    ];

    /**
     * Definisi relasi dengan model Reservation.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_code', 'order_code');
    }
}
