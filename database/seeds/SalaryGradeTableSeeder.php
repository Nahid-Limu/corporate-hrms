<?php

use Illuminate\Database\Seeder;

class SalaryGradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_salary_grade')->insert([
            [
                'id'   => 1,
                'grade_name' => 'G1',
                'basic' => 13000,
                'house' => 500,
                'medical' => 600,
                'transportation' => 300,
                'food' => 900,
            ],
            [
                'id'   => 2,
                'grade_name' => 'G2',
                'basic' => 14000,
                'house' => 500,
                'medical' => 600,
                'transportation' => 300,
                'food' => 900,
            ],
            [
                 'id'   => 3,
                'grade_name' => 'G3',
                'basic' => 15000,
                'house' => 500,
                'medical' => 600,
                'transportation' => 300,
                'food' => 900,
            ],
            [
                 'id'   => 4,
                'grade_name' => 'G4',
                'basic' => 16000,
                'house' => 500,
                'medical' => 600,
                'transportation' => 300,
                'food' => 900,
            ],
            [
                 'id'   => 5,
                'grade_name' => 'G5',
                'basic' => 17000,
                'house' => 500,
                'medical' => 600,
                'transportation' => 300,
                'food' => 900,
            ],
            [
                 'id'   => 6,
                'grade_name' => 'G6',
                'basic' => 18000,
                'house' => 500,
                'medical' => 600,
                'transportation' => 300,
                'food' => 900,
            ],
        ]);
    }
}
