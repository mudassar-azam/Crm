<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\Country;
use App\Models\Availability;
use App\Models\AccountPaymentDetail;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{

    public function run()
    {
        DB::table('resources')->insert([
            [
                'name' => 'bakra engineer',
                'contact_no' => '1234567890',
                'group_link' => 'http://example.com/group',
                'email' => 'engineer@chaseitglobal.com',
                'region' => 'North America',
                'whatsapp_link' => 'http://example.com/whatsapp',
                'certification' => 'Certified PHP Developer',
                'worked_with_us' => true,
                'whatsapp' => '1234567890',
                'linked_in' => 'http://linkedin.com/in/johndoe',
                'tools_catagory' => 'Development',
                'language' =>'english : A1 , urdu : B2',
                'country_id' => 131,
                'city_name' => 'khushab',
                'latitude' => 48.21016006,
                'longitude' => 16.36915967,
                'address' => '123 Main St, New York, NY',
                'work_status' => 'Available',
                'resume' => 'http://example.com/resume',
                'visa' => 'H1B',
                'license' => 'A1234567',
                'passport' => 'P1234567',
                'daily_rate' => 500.00,
                'hourly_rate' => 50.00,
                'weekly_rates' => '1200',
                'monthly_rates' => '1500',
                'rate_currency' => 'USD',
                'half_day_rates' => 250.00,
                'rate_snap' => 'Snapshot of rates',
                'account_payment_details_id' => 1,
                'user_id' => 6,    
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'contact_no' => '0987554321',
                'group_link' => 'http://example.com/group',
                'email' => 'jane1@example.com',
                'region' => 'Europe',
                'whatsapp_link' => 'http://example.com/whatsapp',
                'certification' => 'Certified Laravel Developer',
                'worked_with_us' => false,
                'whatsapp' => '0987554321',
                'linked_in' => 'http://linkedin.com/in/janesmith',
                'tools_catagory' => 'Design',
                'language' =>'english : A1 , urdu : B2',
                'country_id' => 131,
                'city_name' => 'sargodha',
                'latitude' => 48.21016006,
                'longitude' => 16.36915967,
                'address' => '456 Queen St, London, UK',
                'work_status' => 'Unavailable',
                'resume' => 'http://example.com/resume',
                'visa' => 'None',
                'license' => 'B7554321',
                'passport' => 'Q7554321',
                'daily_rate' => 400.00,
                'hourly_rate' => 40.00,
                'weekly_rates' => '1200',
                'monthly_rates' => '1500',
                'rate_currency' => 'GBP',
                'half_day_rates' => 200.00,
                'rate_snap' => 'Snapshot of rates',
                'account_payment_details_id' => 2,
                'user_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],          
        ]);
    }
}
