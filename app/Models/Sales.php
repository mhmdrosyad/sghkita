<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    // Primary key
    protected $primaryKey = 'id';

    // Disable timestamps if not used
    public $timestamps = true;

    // Fillable attributes
    protected $fillable = [
        'name',
        'nik',
        'address',
        'ktp_address',
        'no_hp',
        'no_hp_alt',
        'ktp_foto',
    ];

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_sp', 'id');
    }
}
