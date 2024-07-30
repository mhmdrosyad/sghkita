<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    // Primary key
    protected $primaryKey = 'id';

    // Disable timestamps if not used
    public $timestamps = true;

    // Fillable attributes
    protected $fillable = [
        'name',
        'agency',
        'no_hp',
        'no_hp_alt',
    ];

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'customer_id', 'id');
    }
}
