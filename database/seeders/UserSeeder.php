<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'user_id' => 1,
            'user_name' => 'Admin',
            'role_id' => 1,
            'check_in' => '10:00 AM',
            'check_out' => '10:00 PM',
            'email' => 'admin@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'user_id' => 2,
            'user_name' => 'HR Manager',
            'role_id' => 2,
            'check_in' => '10:00 AM',
            'check_out' => '10:00 PM',
            'email' => 'hrm@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'user_id' => 3,
            'user_name' => 'Recruitment Manager',
            'role_id' => 3,
            'check_in' => '11:00 AM',
            'check_out' => '11:00 PM',
            'email' => 'rm@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'user_id' => 4,
            'user_name' => 'Service Delivery Manager',
            'role_id' => 4,
            'check_in' => '11:00 AM',
            'check_out' => '11:00 PM',
            'email' => 'sdm@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'user_id' => 5,
            'user_name' => 'Accounts Manager',
            'role_id' => 5,
            'check_in' => '12:00 AM',
            'check_out' => '12:00 PM',
            'email' => 'am@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'user_id' => 6,
            'user_name' => 'Lead',
            'role_id' => 6,
            'check_in' => '12:00 AM',
            'check_out' => '12:00 PM',
            'email' => 'lead@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => 9,
            'user_name' => 'Member',
            'role_id' => 7,
            'check_in' => '1:00 AM',
            'check_out' => '1:00 PM',
            'email' => 'member@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => 12,
            'user_name' => 'BD Manager',
            'role_id' => 8,
            'check_in' => '1:00 AM',
            'check_out' => '1:00 PM',
            'email' => 'bdm@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => 12,
            'user_name' => 'Engineer',
            'role_id' => null,
            'check_in' => null,
            'check_out' => null,
            'role_type' => 'engineer',
            'email' => 'engineer@chaseitglobal.com',
            'password' => Hash::make('12345678'),
            'vacation' => 18,
            'sick_leave' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
