<?php

namespace Database\Seeders;

use App\Models\EngineerTool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EngineerToolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EngineerTool::create(['name' => 'eHammer']);
        EngineerTool::create(['name' => 'eScrewdriver']);
        EngineerTool::create(['name' => 'eWrench']);
        EngineerTool::create(['name' => 'ePliers']);
        EngineerTool::create(['name' => 'eSaw']);
    }
}
