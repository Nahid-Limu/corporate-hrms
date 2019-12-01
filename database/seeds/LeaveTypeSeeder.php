<?php

use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_leave_type')->insert([
            [
                
                'id'=>1, 
                'leave_type'=>'maternity leave',
                'total_days'=> 90,
                'status'=> 1,
                
            ],
            [
                'id'=>2,
                'leave_type'=>'sick leave',
                'total_days'=> 15,
                'status'=> 1,
                
            ],
        ]);
    }
}
