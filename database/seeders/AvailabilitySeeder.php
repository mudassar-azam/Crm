<?php

namespace Database\Seeders;

use App\Models\Availability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Availability::create(['name' => 'Not Available']);
        Availability::create(['name' => 'Monday']);
        Availability::create(['name' => 'Tuesday']);
        Availability::create(['name' => 'Wednesday']);
        Availability::create(['name' => 'Thursday']);
        Availability::create(['name' => 'Friday']);
        Availability::create(['name' => 'Saturday']);
        Availability::create(['name' => 'Sunday']);
        Availability::create(['name' => 'Depends']);
        Availability::create(['name' => 'After Hours']);
    }
}
