<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_code',
        'customer_id',
        'checkin',
        'checkout',
        'res_category_id',
        'pax',
        'rate',
        'note',
        'id_sp',
        'user_id',
        'status'
    ];

    protected $attributes = [
        'status' => 'waiting_list', // Default value for new instances
    ];
    protected $casts = [
        'checkin' => 'datetime',
        'checkout' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function resCategory()
    {
        return $this->belongsTo(ResCategory::class, 'res_category_id', 'id_rescategory');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'id_sp');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'reservation_code', 'order_code');
    }
    // In Reservation.php model
    public function payments()
    {
        return $this->hasMany(Payment::class, 'reservation_code', 'order_code');
    }
    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }
}
