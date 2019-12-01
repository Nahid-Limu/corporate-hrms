<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
          [
                'id'           => 1,
                'name' => 'view_dashboard',
                'display_name' => 'View Dashboard',
            ],
            [
                'id'           => 2,
                'name' => 'manage_users',
                'display_name' => 'Manage Users',
            ],
            [
                'id'           => 3,
                'name' => 'manage_role',
                'display_name' => 'Manage Role',
            ],
            [
                'id'           => 4,
                'name' => 'manage_permission',
                'display_name' => 'Manage Permission',
            ],
            [
                'id'           => 5,
                'name' => 'manage_employee',
                'display_name' => 'Manage Employee',
            ],
            [
                'id'           => 6,
                'name' => 'manage_task',
                'display_name' => 'Manage Task',
            ],
            [
                'id'           => 7,
                'name' => 'manage_project',
                'display_name' => 'Manage Project',
            ],
            [
                'id'           => 8,
                'name' => 'manage_training',
                'display_name' => 'Manage Training',
            ],
            [
                'id'           => 9,
                'name' => 'file_management',
                'display_name' => 'File Management',
            ],
            [
                'id'           => 10,
                'name' => 'manage_leave',
                'display_name' => 'Manage Leave',
            ],
            [
                'id'           => 11,
                'name' => 'payroll',
                'display_name' => 'Payroll',
            ],
            [
                'id'           => 12,
                'name' => 'benefit',
                'display_name' => 'Benefit',
            ],
            [
                'id'           => 13,
                'name' => 'manage_expense',
                'display_name' => 'Manage Expense',
            ],
            [
                'id'           => 14,
                'name' => 'settings',
                'display_name' => 'Settings',
            ],
            [
                'id'           => 15,
                'name' => 'manage_attendance',
                'display_name' => 'Manage Attendance',
            ],
            [
                'id'           => 16,
                'name' => 'expense_edit',
                'display_name' => 'Expense Edit',
            ],
            [
                'id'           => 17,
                'name' => 'expense_create',
                'display_name' => 'Expense Create',
            ],
            [
                'id'           => 18,
                'name' => 'users',
                'display_name' => 'Users',
            ],
            [
                'id'           => 19,
                'name' => 'role',
                'display_name' => 'Role',
            ],
            [
                'id'           => 20,
                'name' => 'permission',
                'display_name' => 'Permission',
            ],
            [
                'id'           => 21,
                'name' => 'assign_task',
                'display_name' => 'Assign Task',
            ],
            [
                'id'           => 22,
                'name' => 'task_settings',
                'display_name' => 'Task Settings',
            ],
            [
                'id'           => 23,
                'name' => 'client_list',
                'display_name' => 'Client List',
            ],
            [
                'id'           => 24,
                'name' => 'project_list',
                'display_name' => 'Project List',
            ],
            [
                'id'           => 25,
                'name' => 'assign_project',
                'display_name' => 'Assign Project',
            ],
            [
                'id'           => 26,
                'name' => 'training_list',
                'display_name' => 'Training List',
            ],
            [
                'id'           => 27,
                'name' => 'assign_training',
                'display_name' => 'Assign Training',
            ],
            [
                'id'           =>28,
                'name' => 'training_request',
                'display_name' => 'Training Request',
            ],
            [
                'id'           =>29,
                'name' => 'employee_create',
                'display_name' => 'Employee Create',
            ],
            [
                'id'           =>30,
                'name' => 'employee_list',
                'display_name' => 'Employee List',
            ],
            [
                'id'           =>31,
                'name' => 'employee_status',
                'display_name' => 'Employee Status',
            ],
            [
                'id'           =>32,
                'name' => 'employee_group',
                'display_name' => 'Employee Group',
            ],
            [
                'id'           =>33,
                'name' => 'employee_assets_list',
                'display_name' => 'Employee Assets List',
            ],
            [
                'id'           =>34,
                'name' => 'employee_favourites',
                'display_name' => 'Employee Favourites',
            ],
            [
                'id'           =>35,
                'name' => 'assign_salary',
                'display_name' => 'Assign Salary',
            ],
            [
                'id'           =>36,
                'name' => 'salary_list',
                'display_name' => 'Salary List',
            ],
            [
                'id'           =>37,
                'name' => 'process_salary',
                'display_name' => 'Process Salary',
            ],
            [
                'id'           =>38,
                'name' => 'grade_settings',
                'display_name' => 'Grade Settings',
            ],
            [
                'id'           =>39,
                'name' => 'salary_settings',
                'display_name' => 'Salary Settings',
            ],
            [
                'id'           =>40,
                'name' => 'benefit_list',
                'display_name' => 'Benefit List',
            ],
            [
                'id'           =>41,
                'name' => 'provident_fund',
                'display_name' => 'Provident Fund',
            ],
            [
                'id'           =>42,
                'name' => 'festival_bonus',
                'display_name' => 'Festival Bonus',
            ],
            [
                'id'           =>43,
                'name' => 'severance_package',
                'display_name' => 'Severance Package',
            ],
            [
                'id'           =>44,
                'name' => 'expense_list',
                'display_name' => 'Expense List',
            ],
            [
                'id'           =>45,
                'name' => 'expense_settings',
                'display_name' => 'Expense Settings',
            ],
            [
                'id'           =>46,
                'name' => 'meeting_list',
                'display_name' => 'Meeting List',
            ],
            [
                'id'           =>47,
                'name' => 'meeting_employee_list',
                'display_name' => 'Meeting Employee List',
            ],
            [
                'id'           =>48,
                'name' => 'announcement_list',
                'display_name' => 'Announcement List',
            ],
            [
                'id'           =>49,
                'name' => 'employee_report',
                'display_name' => 'Employee Report',
            ],
            [
                'id'           =>50,
                'name' => 'project',
                'display_name' => 'Project',
            ],
            [
                'id'           =>51,
                'name' => 'Client_report',
                'display_name' => 'Client Report',
            ],
            [
                'id'           =>52,
                'name' => 'attendance_report',
                'display_name' => 'Attendance Report',
            ],
            [
                'id'           =>53,
                'name' => 'employee_profile',
                'display_name' => 'Employee profile',
            ],

        ]);
    }
}
