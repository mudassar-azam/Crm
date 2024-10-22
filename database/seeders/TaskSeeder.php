<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $tasks = [];

        for ($i = 1; $i <= 10; $i++) {
            $tasks[] = [
                'assign_to' => rand(1, 4),
                'start_date' => now()->addDays($i)->toDateString(),
                'due_date' => now()->addDays($i + 7)->toDateString(),
                'priority' => ['high', 'medium', 'low'][array_rand(['high', 'medium', 'low'])],
                'bucket' => Str::random(10),
                'description' => 'Task description ' . $i,
                'status' => 'Not Started',
                'task_completion_status' => 'incomplete',
                'location' => 'sargodha',
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('tasks')->insert($tasks);
    }
}
