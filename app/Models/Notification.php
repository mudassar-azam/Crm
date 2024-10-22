<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user1_id', 'user2_id', 'message'];

    public function doneby()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user_two()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }
}
