<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('clients')->insert([
            [
                'company_name' => 'Company A',
                'registration_no' => '123456',
                'company_address' => '123 Main Street, City, Country',
                'company_hq' => 'City A',
                'user_id' => 1,
                'type' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'Company B',
                'registration_no' => '654321',
                'company_address' => '456 Elm Street, City, Country',
                'company_hq' => 'City B',
                'user_id' => 2,
                'type' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'Company c',
                'registration_no' => '654321',
                'company_address' => '456 Elm Street, City, Country',
                'company_hq' => 'City c',
                'user_id' => 3,
                'type' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
