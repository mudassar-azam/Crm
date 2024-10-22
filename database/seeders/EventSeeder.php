<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $events = [
            [
                'event_name' => 'Event 1',
                'priority' => 'High',
                'category' => 'Category 1',
                'remark' => 'Remark for event 1',
                'date' => Carbon::create(2024, 7, 1),
                'time' => '02:00:00' // 2:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 2',
                'priority' => 'Medium',
                'category' => 'Category 2',
                'remark' => 'Remark for event 2',
                'date' => Carbon::create(2024, 7, 2),
                'time' => '03:00:00' // 3:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 3',
                'priority' => 'Low',
                'category' => 'Category 3',
                'remark' => 'Remark for event 3',
                'date' => Carbon::create(2024, 7, 3),
                'time' => '04:00:00' // 4:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 4',
                'priority' => 'High',
                'category' => 'Category 1',
                'remark' => null,
                'date' => Carbon::create(2024, 7, 4),
                'time' => '05:00:00' // 5:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 5',
                'priority' => 'Medium',
                'category' => 'Category 2',
                'remark' => 'Remark for event 5',
                'date' => Carbon::create(2024, 7, 5),
                'time' => '06:00:00' // 6:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 6',
                'priority' => 'Low',
                'category' => 'Category 3',
                'remark' => 'Remark for event 6',
                'date' => Carbon::create(2024, 7, 6),
                'time' => '07:00:00' // 7:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 7',
                'priority' => 'High',
                'category' => 'Category 1',
                'remark' => 'Remark for event 7',
                'date' => Carbon::create(2024, 7, 7),
                'time' => '08:00:00' // 8:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 8',
                'priority' => 'Medium',
                'category' => 'Category 2',
                'remark' => null,
                'date' => Carbon::create(2024, 7, 8),
                'time' => '09:00:00' // 9:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 9',
                'priority' => 'Low',
                'category' => 'Category 3',
                'remark' => 'Remark for event 9',
                'date' => Carbon::create(2024, 7, 9),
                'time' => '10:00:00' // 10:00 AM in 24-hour format
            ],
            [
                'event_name' => 'Event 10',
                'priority' => 'High',
                'category' => 'Category 1',
                'remark' => 'Remark for event 10',
                'date' => Carbon::create(2024, 7, 10),
                'time' => '11:00:00' // 11:00 AM in 24-hour format
            ],
        ];

        DB::table('events')->insert($events);
    }
}
