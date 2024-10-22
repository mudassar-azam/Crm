<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'hardware',
                // Add other columns and their values here
            ],
            [
                'name' => 'software'
                // Add other columns and their values here
            ],
            [
                'name' => 'laptop repair',
                // Add other columns and their values here
            ],
            // Add more sample data as needed
        ];

        // Insert data into the table
        DB::table('skills')->insert($data);
    }
}
