<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_no',
        'group_link',
        'email',
        'region',
        'nationality',
        'language',
        'proficiency_level',
        'whatsapp_link',
        'certification',
        'worked_with_us',
        'whatsapp',
        'linked_in',
        'tools_catagory',
        'BGV',
        'personal_details',
        'right_to_work',
        'record',
        'last_degree',
        'country_id',
        'city_name',
        'latitude',
        'longitude',
        'address',
        'work_status',
        'resume',
        'visa',
        'license',
        'passport',
        'daily_rate',
        'hourly_rate',
        'rates',
        'rate_date',
        'rate_currency',
        'half_day_rates',
        'rate_snap',
        'weekly_rates',
        'monthly_rates',
        'rate_snap',
        'account_payment_details_id',
        'user_id'

    ];
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function nationality()
    {
        return $this->belongsTo(Country::class, 'nationality_foreign_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }



    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function availabilities()
    {
        return $this->belongsToMany(Availability::class);
    }
    
    public function paymentDetails()
    {
        return $this->belongsTo(AccountPaymentDetail::class, 'account_payment_details_id');
    }
    public function tools()
    {

        return $this->belongsToMany(Tool::class);
    }

    public function engineerTools()
    {
        return $this->belongsToMany(EngineerTool::class, 'engineer_resource_pivot');
    }

    public function resourceNationalities()
    {
        return $this->belongsToMany(Nationality::class, 'resources_nationality_pivot');
    }
    public function bgvs()
    {
        return $this->hasMany(BGV::class);
    }


    public function scopeFilterByCountry($query, $countryId)
    {
        return $query->where('country_id', $countryId);
    }
    
    public function scopeFilterByCity($query, $tech_city)
    {
        return $query->where('city_name', $tech_city);
    }

    public function scopeFilterByWorked($query, $worked)
    {

        return $query->where('worked_with_us', $worked);
    }

    // Scope to filter by ID
    public function scopeFilterById($query, $id)
    {
        return $query->where('id', $id);
    }
    // Scope to filter by name
    public function scopeFilterByName($query, $name)
    {
        return $query->whereRaw('LOWER(`name`) LIKE ?', ['%' . strtolower($name) . '%']);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    
    public function scopeFilterByTech($query, $resourcId)
    {
        return $query->where('id', $resourcId);
    }

    public function techCurrency()
    {
        return $this->belongsTo(Currency::class, 'tech_currency_id');
    }
}
