<?php

use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_designations')->insert([
            [   
                'designation_name'           => 'Software Engineer',
                'status'                => 1,
                'created_by'            => 1,
            ],
            [  
                'designation_name'           => 'Network Engineer',
                'status'                => 1,
                'created_by'            => 1,
            ]
        ]);
    }
}
