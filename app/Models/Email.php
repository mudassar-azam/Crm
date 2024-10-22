<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'locaion',
        'email_body',
        'location',
        'subject',
        'express',
        'email_note'
    ];
}
