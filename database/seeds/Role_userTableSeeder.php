<?php

use Illuminate\Database\Seeder;

class Role_userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            //  [  'role_id'           => 2,
            //     'user_id'         => 1,
            //     'user_type'        => 'AppUser'
            // ],
            // [  'role_id'           => 1,
            //     'user_id'         => 2,
            //     'user_type'        => 'AppUser'
            // ],
            [  'role_id'           => 5,
                'user_id'         => 3,
                'user_type'        => 'AppUser'
            ],
            [   'role_id'           => 5,
                'user_id'         => 4,
                'user_type'        => 'AppUser'
            ],
            [   'role_id'           => 3,
                'user_id'         => 5,
                'user_type'        => 'AppUser'
            ],   
            [   'role_id'           => 3,
                'user_id'         => 6,
                'user_type'        => 'AppUser'
            ],   
        ]);
    }
}
