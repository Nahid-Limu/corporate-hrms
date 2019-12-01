<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class SalarySettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_salary_settings')->insert([
            [
                'id' => 1,
                'title' => 'Over Time',
                'status' => 1,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ],
            [
                'id' => 2,
                'title' => 'Late',
                'status' => 1,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ],
            [
                'id' => 3,
                'title' => 'Absent',
                'status' => 1,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ],
        ]);
    }
}
