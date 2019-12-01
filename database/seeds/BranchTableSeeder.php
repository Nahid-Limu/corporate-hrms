<?php

use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_branch')->insert([
            [   
                'branch_name'           => 'Branch One',
                'address'               => 'Uttara',
                'status'                => 1,
                'created_by'            => 1,
            ],
            [  
                'branch_name'           => 'Branch Two',
                'address'               => 'Gazipur',
                'status'                => 1,
                'created_by'            => 1,
            ]
        ]);
    }
}
