<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // The table associated with the model (optional if the table name is the plural form of the model name)
    protected $table = 'payments';

    // The attributes that are mass assignable
    protected $fillable = [
        'type',
        'reservation_code',
        'transaction_id',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_code', 'order_code');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
