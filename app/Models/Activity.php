<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_detail',
        'email_screenshot',
        'activity_start_date',
        'location',
        'activity_description',
        'customer_name',
        'customer_service_type',
        'customer_rates',
        'tech_country_id',
        'tech_city',
        'tech_name',
        'tech_service_type',
        'tech_rates',
        'po_number',
        'other_project_name',
        'customer_currency_id',
        'total_customer_payment',
        'duration_cust',
        'start_date_time',
        'end_date_time',
        'time_difference',
        'activity_status',
        'total_tech_payments',
        'tech_currency_id',
        'duration',
        'sign_of_sheet',
        'resource_id',
        'client_id',
        'created_at',
        'updated_at',
        'user_id',
        'confirmed_by',
        'completed_by',
        'approved_by',
        'project_id'
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeFilterByFromDate($query, $fromDate)
    {
        return $query->whereDate('created_at', '>=', $fromDate);
    }

    public function scopeFilterByToDate($query, $toDate)
    {
        return $query->whereDate('created_at', '<=', $toDate);
    }
    public function scopeFilterByCompany($query, $companyId)
    {
        return $query->where('client_id', $companyId);
    }

    public function techCurrency()
    {
        return $this->belongsTo(Currency::class, 'tech_currency_id');
    }

    public function customerCurrency()
    {
        return $this->belongsTo(Currency::class, 'customer_currency_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'activity_id');
    }

    public function invoicesWithoutClient()
    {
        return $this->hasMany(Invoice::class, 'activity_id')->whereNull('client_id')->where('status' , 'received');
    }

    public function country()
    {
        return $this->belongsTo(Country::class , 'tech_country_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
