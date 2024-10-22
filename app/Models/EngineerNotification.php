<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineerNotification extends Model
{
    use HasFactory;

    protected $fillable = ['engineer_id', 'message'];
}
