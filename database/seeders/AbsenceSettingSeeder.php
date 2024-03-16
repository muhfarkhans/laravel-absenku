<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsenceSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('absence_settings')->delete();
        DB::table('absence_settings')->insert([
            "id" => 1,
            "check_in_mark" => "08:00:00",
            "check_out_mark" => "16:00:00",
            "updated_by" => 1,
        ]);
    }
}
