<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name', 
        'email', 
        'role', 
        'user_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
