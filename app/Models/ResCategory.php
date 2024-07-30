<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResCategory extends Model
{
    use HasFactory;

    protected $table = 'res_categories';

    // Primary key
    protected $primaryKey = 'id_rescategory';

    // Disable timestamps if not used
    public $timestamps = true;

    // Fillable attributes
    protected $fillable = [
        'name',
        'note',
    ];

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'res_category_id', 'id_rescategory');
    }
}
