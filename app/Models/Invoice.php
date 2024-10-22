<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public $guarded=[];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
