<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Seeder;

class AnounsementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('anounsements')->insert([
            ['anounsement' => 'First announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Second announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Third announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Fourth announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Fifth announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Sixth announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Seven announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Eight announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Nine announcement', 'created_at' => now(), 'updated_at' => now()],
            ['anounsement' => 'Tenth announcement', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
