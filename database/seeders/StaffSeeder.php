<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Staff;
use App\Models\User;
use App\Models\Department;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::where('role','staff')->delete();
        Staff::truncate();

        Schema::enableForeignKeyConstraints();

        $staffData = [
            [
                'name' => 'Prof. David Chen',
                'email' => 'david.chen@college.com',
                'employee_id' => 'E-101',
                'designation' => 'Professor',
                'code' => 'CSE',
                'hire_date' => '2018-08-01',
                'role'=>'staff'
            ],
            [
                'name' => 'Dr. Sarah Kim',
                'email' => 'sarah.kim@college.com',
                'employee_id' => 'E-102',
                'designation' => 'Associate Professor',
                'code' => 'IT',
                'hire_date' => '2019-05-15',
                'role'=>'staff'
            ],
            [
                'name' => 'Mr. Robert Brown',
                'email' => 'robert.brown@college.com',
                'employee_id' => 'E-103',
                'designation' => 'Lab Technician',
                'code' => 'ME',
                'hire_date' => '2021-01-20',
                'role'=>'staff'
            ],
            [
                'name' => 'Dr. Anita Patel',
                'email' => 'anita.patel@college.com',
                'employee_id' => 'E-104',
                'designation' => 'Professor',
                'code' => 'ECE',
                'hire_date' => '2017-11-30',
                'role'=>'staff'
            ],
            [
                'name' => 'Dr. Anil Kumar',
                'email' => 'anil.kumar@college.com',
                'employee_id' => 'E-105',
                'designation' => 'Professor',
                'code' => 'EE',
                'hire_date' => '2013-9-20',
                'role'=>'staff'
            ],
        ];

        foreach($staffData as $staff){
            $department = Department::where('code', $staff['code'])->first();

            if (!$department) {
                throw new \Exception("Department with code '{$staff['code']}' not found. Staff '{$staff['name']}' cannot be created.");
            }

            $user = User::create([
                'name' => $staff['name'],
                'email' => $staff['email'],
                'password' => Hash::make($staff['password'] ?? 'password'),
                'role' => $staff['role'],
            ]);

            $user->staff()->create([
                'department_id' => $department->id,
                'employee_id' => $staff['employee_id'],
                'designation' => $staff['designation'],
                'hire_date' => $staff['hire_date'],
            ]);
        }
    }
}
