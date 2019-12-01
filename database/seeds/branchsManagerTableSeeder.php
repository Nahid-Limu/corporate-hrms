<?php

use Illuminate\Database\Seeder;

class branchsManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $userAdminUserID = 5;
        $userAdminRoleID = 3;

        // Assign user to a role
        DB::table('role_user')->insert([
            [
                'role_id'    => $userAdminRoleID,
                'user_id' => $userAdminUserID,
                'user_type' => 'App\User',
            ],
            [
                'role_id'    =>1,
                'user_id' => 2,
                'user_type' => 'App\User',
            ]
        ]);

        $allPermission = DB::table('permissions')->get();

        $rolePermissions = [];
        
        foreach ($allPermission as $p) {
            $tempr = [];
            $tempr['permission_id'] = $p->id;
            $tempr['role_id'] = $userAdminRoleID;
            $rolePermissions[] = $tempr;
        }
        // Asign all permissions to the super admin role
        DB::table('permission_role')->insert($rolePermissions);
    }
}
