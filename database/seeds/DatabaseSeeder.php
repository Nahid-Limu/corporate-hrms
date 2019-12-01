<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([

            UsersTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            EmployeeTableSeeder::class,
            LeaveTypeSeeder::class,
            DepartmentTableSeeder::class,
            DesignationTableSeeder::class,
            BranchTableSeeder::class,
            CompanyInfosTableSeeder::class,
            SalaryGradeTableSeeder::class,
            SalarySettingsTableSeeder::class,
            User_role_permissionTableSeeder::class,
            ShiftTableSeeder::class,
            WeekLeaveTableSeeder::class,
            Role_permissionTableSeeder::class,
            Role_userTableSeeder::class
        ]);
    }
}
