<?php

use Illuminate\Database\Seeder;

class WeekLeaveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('tb_week_leave')->insert([
            [  'id'           => 1,
                'day_id'         => 1,
                'day'        => 'Sunday',
                'status'     => 0,
            ],
            [  'id'           => 2,
                'day_id'         => 2,
                'day'        => 'Monday',
                'status'     => 0,
            ],
            [  'id'           => 3,
                'day_id'         => 3,
                'day'        => 'Tuesday',
                'status'     => 0,
            ],
            [  'id'           => 4,
                'day_id'         => 4,
                'day'        => 'Wednesday',
                'status'     => 0,
            ],
            [  'id'           => 5,
                'day_id'         => 5,
                'day'        => 'Thursday',
                'status'     => 0,
            ],
            [  'id'           => 6,
                'day_id'         => 6,
                'day'        => 'Friday',
                'status'     => 1,
            ],
            [  'id'           => 7,
                'day_id'         => 7,
                'day'        => 'Saturday',
                'status'     => 0,
            ],
            
        ]);
    }
    
}
