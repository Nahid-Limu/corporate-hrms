<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployeeTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker::create();
        foreach (range(1,1000) as $index) {
            $employee_fake_data[]=[
                'employeeId'=>$faker->uuid,
                'emp_first_name'=>$faker->firstName,
                'emp_lastName'=> $faker->lastName,
                'branch_id'=>$faker->numberBetween(1,2),
                'emp_department_id'=>$faker->numberBetween(1,2),
                'emp_designation_id'=>$faker->numberBetween(1,2),
                'emp_gender_id'=>$faker->numberBetween(1,2),
                'emp_shift_id'=>$faker->numberBetween(1,2),
                'emp_father_name'=>$faker->name,
                'emp_mother_name'=>$faker->name,
                'emp_email'=>$faker->email,
                'emp_phone'=>$faker->phoneNumber,
                'emp_dob'=>$faker->date(),
                'emp_joining_date'=>$faker->date(),
                'emp_probation_period'=>6,
                'emp_religion'=>'Hindu',
                'emp_marital_status'=>1,
                'emp_blood_group'=>1,
                'emp_bank_account'=>$faker->bankAccountNumber,
                'emp_card_number'=>45,
                'emp_nid'=>$faker->uuid,
                'emp_nationality'=>'Bangladeshi',
                'emp_ot_status'=>1,
                'emp_parmanent_address'=>$faker->address,
                'emp_current_address'=>$faker->address,
                'emp_emergency_phone'=>32423432,
                'emp_emergency_address'=>$faker->address,
                'emp_account_status'=>1,
            ];
        }
        DB::table('tb_employee')->insert($employee_fake_data);
    }
}
