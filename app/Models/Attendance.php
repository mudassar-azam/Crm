<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'in',
        'out',
        'worked_hours',
        'user_id',
        'break',
        'arrived_early',
        'arrived_late',
        'left_late',
        'left_early',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilterByFromDate($query, $fromDate)
    {
        return $query->whereDate('date', '>=', $fromDate);
    }

    public function scopeFilterByToDate($query, $toDate)
    {
        return $query->whereDate('date', '<=', $toDate);
    }
}
