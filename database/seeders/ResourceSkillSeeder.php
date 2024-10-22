<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResourceSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $resources = Resource::all();
        $skills = Skill::all();

        foreach ($resources as $resource) {
            $resource->skills()->attach(
                $skills->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
