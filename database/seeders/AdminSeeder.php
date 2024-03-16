<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            "id" => 1,
            "name" => "admin",
            "email" => "admin@admin.admin",
            "password" => bcrypt("password"),
        ]);
    }
}
