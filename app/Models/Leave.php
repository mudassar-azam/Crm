<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'type',
        'user_id',
        'duration',
        'start_date',
        'end_date',
        'status',
        'comment',
        'approved_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use HasFactory;
}
