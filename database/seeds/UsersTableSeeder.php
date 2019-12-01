<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
             [  'id'           => 1,
                'emp_id'       => '',
                'emp_branch_id'       => '',
                'name'         => 'admin',
                'email'        => 'admin@email.com',
                'theme_style'  => '1',
                'password'     => bcrypt('admin'),
            ],
            [   'id'           => 2,
                'emp_id'       => '',
                'emp_branch_id'       => '',
                'name'         => 'super admin',
                'email'        => 'super@email.com',
                'theme_style'  => '1',
                'password'     => bcrypt('admin'),
            ],

             [  'id'           => 3,
                'emp_id'       => 3,
                'emp_branch_id'       => 1,
                'name'         => 'Demo One',
                'email'        => 'demo_one@email.com',
                 'theme_style'  => '1',
                'password'     => bcrypt('employee'),
            ],
            [   'id'           => 4,
                'emp_id'       => 4,
                'emp_branch_id'       => 1,
                'name'         => 'Demo Two',
                'email'        => 'demo_two@email.com',
                'theme_style'  => '1',
                'password'     => bcrypt('employee'),
            ],
            [   'id'           => 5,
                'emp_id'       => 5,
                'emp_branch_id'       => 1,
                'name'         => 'branch manager',
                'email'        => 'branch_manager@email.com',
                'theme_style'  => '1',
                'password'     => bcrypt('admin'),
            ],
            [   'id'           => 6,
                'emp_id'       => 6,
                'emp_branch_id'       => 2,
                'name'         => 'branch manager',
                'email'        => 'branch_manager2@email.com',
                'theme_style'  => '1',
                'password'     => bcrypt('admin'),
            ],

          
            // [   'id'           => 6,
            //     'name'         => 'accounting ',
            //     'email'        => 'accounting@email.com',
            //     'password'     => bcrypt('admin'),
            // ],
            // [   'id'           => 7,
            //     'name'         => 'project manager',
            //     'email'        => 'projectmanager@email.com',
            //     'password'     => bcrypt('admin'),
            // ],
            // [   'id'           => 8,
            //     'name'         => 'executive',
            //     'email'        => 'executive@email.com',
            //     'password'     => bcrypt('admin'),
            // ],

        ]);
    }
}
