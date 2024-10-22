<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'registration_no',
        'company_address',
        'company_hq',
        'form_nda_coc_sow',
        'worth',
        'sport_areas',
        'status',
        'user_id',
        'type',
    ];
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function scopeFilterByFromDate($query, $fromDate)
    {
        return $query->whereDate('created_at', '>=', $fromDate);
    }

    public function scopeFilterByToDate($query, $toDate)
    {
        return $query->whereDate('created_at', '<=', $toDate);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
