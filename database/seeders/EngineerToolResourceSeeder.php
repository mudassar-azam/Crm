<?php

namespace Database\Seeders;

use App\Models\EngineerTool;
use App\Models\Resource;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EngineerToolResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get some sample resources and tools
        $resources = Resource::all();
        $tools = EngineerTool::all();

        // Attach tools to resources
        $resources->each(function ($resource) use ($tools) {
            // Randomly select a few tools to attach to each resource
            $selectedTools = $tools->random(rand(1, count($tools)));
            $resource->engineerTools()->attach($selectedTools);
        });
    }
}
