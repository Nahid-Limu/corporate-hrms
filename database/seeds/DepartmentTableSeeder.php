<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_departments')->insert([
            [   
                'department_name'           => 'CSE',
                'status'                => 1,
                'created_by'            => 1,
            ],
            [  
                'department_name'           => 'EEE',
                'status'                => 1,
                'created_by'            => 1,
            ]
        ]);
    }
}
