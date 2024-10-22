<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Resource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvaibilityResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $resources = Resource::all();
        $availabilities = Availability::all();

        foreach ($resources as $resource) {
            $resource->availabilities()->attach(
                $availabilities->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
