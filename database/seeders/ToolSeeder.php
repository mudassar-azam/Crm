<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tool::create(['name' => 'Hammer']);
        Tool::create(['name' => 'Screwdriver']);
        Tool::create(['name' => 'Wrench']);
        Tool::create(['name' => 'Pliers']);
        Tool::create(['name' => 'Saw']);
    }
}
