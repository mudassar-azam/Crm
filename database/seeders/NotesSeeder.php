<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class NotesSeeder extends Seeder
{
    public function run(): void
    {
        $notes = [];

        for ($i = 1; $i <= 15; $i++) {
            $notes[] = [
                'user_id' => rand(1, 5),
                'status' => 'active',
                'note' => Str::random(50),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('notes')->insert($notes);
        
    }
}