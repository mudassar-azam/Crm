<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    
    public function run()
    {
        $timestamp = Carbon::now();
        DB::table('roles')->insert([
            ['name' => 'Admin', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'HR Manager', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Recruitment Manager', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Service Delivery Manager', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Accounts Manager', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Lead', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Member', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'BD Manager', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);
    }
}
