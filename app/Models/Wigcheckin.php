<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WigCheckin extends Model
{
    protected $table = 'wig_checkins';

    protected $primaryKey = 'checkin_code';

    public $incrementing = false; // Karena primary key bukan auto-increment
    protected $keyType = 'string'; // Tipe primary key adalah string

    protected $fillable = [
        'checkin_code',
        'guest_name',
        'room',
        'rate',
        'pay',
        'checkin_time',
        'checkout_time',
        'status',
    ];

    protected $casts = [
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
    ];

    public static function generateCheckinCode()
    {
        // Ambil check-in code terbaru
        $latest = self::latest('checkin_code')->first();

        // Jika ada data sebelumnya, ambil angka terakhir
        if ($latest) {
            $latestCode = substr($latest->checkin_code, 4); // Ambil angka setelah 'CKN-'
            $latestCode = (int) $latestCode; // Convert ke integer
        } else {
            // Jika tidak ada data sebelumnya, mulai dari 0
            $latestCode = 0;
        }

        // Generate kode baru, tambahkan 1 ke angka terakhir
        $newCode = str_pad($latestCode + 1, 3, '0', STR_PAD_LEFT);

        // Format kode check-in baru
        return 'CKN-' . $newCode;
    }

    public function wigInvoice()
    {
        return $this->hasOne(WigInvoice::class, 'checkin_code', 'checkin_code');
    }
}
