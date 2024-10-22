<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoosterOverride extends Model
{
    use HasFactory;

    protected $fillable = [
        'rooster_id',
        'override_date',
        'type'
    ];

    public function rooster()
    {
        return $this->belongsTo(Rooster::class , 'rooster_id');
    }
}
