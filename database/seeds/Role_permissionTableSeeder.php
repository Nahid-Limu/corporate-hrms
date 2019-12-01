<?php

use Illuminate\Database\Seeder;

class Role_permissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        // branch_manager_permissions
      
        $branch_manager_permissions_id = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,];

         for($i=0;$i<count($branch_manager_permissions_id);$i++){

                $insert=DB::table('permission_role')->insert([
                     [
                        'permission_id'      => $branch_manager_permissions_id[$i],
                        'role_id'        => 3,
                    ]   
                ]);
            }
        // end branch_manager_permissions



        // employee_permissions
        $employee_permissions_id = [1];

         for($i=0;$i<count($employee_permissions_id);$i++){

                $insert=DB::table('permission_role')->insert([
                     [
                        'permission_id'      => $employee_permissions_id[$i],
                        'role_id'        => 5,
                    ]   
                ]);
            }


            // end  employee_permissions
    }
}
