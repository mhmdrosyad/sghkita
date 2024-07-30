<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'invoices';

    // The attributes that are mass assignable
    protected $fillable = [
        'reservation_code',
        'description',
        'user_id',
        'total_bill',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_code', 'order_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'reservation_code', 'reservation_code');
    }
}
