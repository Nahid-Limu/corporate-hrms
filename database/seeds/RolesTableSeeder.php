<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id'   => 1,
                'name' => 'super-admin',
                'display_name' => 'Super Admin',
                'description' => 'super admin'
            ],
            [
                'id'   => 2,
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'admin'
            ],
            [
                'id'   => 3,
                'name' => 'branch-manager',
                'display_name' => 'Branch Manager',
                'description' => 'Branch Manager'
            ],
            [
                'id'   => 4,
                'name' => 'hr',
                'display_name' => 'Human resources (HR)',
                'description' => 'Human resources (HR)'
            ],
            [
                'id'   => 5,
                'name' => 'employee',
                'display_name' => 'Employee',
                'description' => 'employee'
            ],
            [
                'id'   => 6,
                'name' => 'accounting',
                'display_name' => 'accounting',
                'description' => 'accounting'
            ],
            [
                'id'   => 7,
                'name' => 'project-manager',
                'display_name' => 'Project Manager',
                'description' => 'project manager'
            ],
            [
                'id'   => 8,
                'name' => 'executive',
                'display_name' => 'Executive',
                'description' => 'executive'
            ],
        ]);
    }
}
