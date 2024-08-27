<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WigInvoice extends Model
{
    use HasFactory;

    protected $table = 'wiginvoices';

    protected $fillable = [
        'checkin_code',
        'payment',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function wigCheckin()
    {
        return $this->belongsTo(WigCheckin::class, 'checkin_code', 'checkin_code');
    }
}
