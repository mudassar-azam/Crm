<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'client_id' => 1, 
                'project_name' => 'Project Alpha',
                'project_sdm' => 'SDM A',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 2, 
                'project_name' => 'Project Beta',
                'project_sdm' => 'SDM B',

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
