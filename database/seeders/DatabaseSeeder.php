<?php

namespace Database\Seeders;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(AvailabilitySeeder::class);
        $this->call(ToolSeeder::class);
        $this->call(EngineerToolsSeeder::class);
        $this->call(AccoundPaymentDetailSeeder::class);
        $this->call(NationalitiesTableSeeder::class);
        $this->call(ResourceToolSeeder::class);
        $this->call(EngineerToolResourceSeeder::class);
        $this->call(ResourceSkillSeeder::class);
        $this->call(AvaibilityResourceSeeder::class);
        $this->call(ResourceSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(AnounsementSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(NotesSeeder::class);
        $this->call(FollowUpClientSeeder::class);
        $this->call(LeaveSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(RoosterSeeder::class);
    }
}
