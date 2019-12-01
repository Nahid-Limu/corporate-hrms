<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_shift')->insert([
             [  'id'           => 1,
                'shift_name'         => 'Morning',
                'entry_time'        => '09:00:00',
                'exit_time'     => '18:00:00',
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ],
        ]);
    }
}
