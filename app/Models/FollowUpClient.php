<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worth',
        'sport_areas',
        'status',
        'company_hq',
        'company_name',
        'type',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeFilterByFromDate($query, $fromDate)
    {
        return $query->whereDate('created_at', '>=', $fromDate);
    }

    public function scopeFilterByToDate($query, $toDate)
    {
        return $query->whereDate('created_at', '<=', $toDate);
    }
}
