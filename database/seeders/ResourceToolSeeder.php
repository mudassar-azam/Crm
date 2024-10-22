<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\Tool;


class ResourceToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get some sample resources and tools
        $resources = Resource::all();
        $tools = Tool::all();

        // Attach tools to resources
        $resources->each(function ($resource) use ($tools) {
            // Randomly select a few tools to attach to each resource
            $selectedTools = $tools->random(rand(1, count($tools)));
            $resource->tools()->attach($selectedTools);
        });
    }
}
