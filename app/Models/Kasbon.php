<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;

    protected $table = 'kasbons';

    protected $fillable = [
        'tgl_pinjam',
        'tgl_kembali',
        'nama',
        'nominal',
        'nominal_kembali',
        'keterangan',
        'user_id',
        'is_paid',
        'tipe'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
