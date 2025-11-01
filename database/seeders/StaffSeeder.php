<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

use App\Models\Staff;
use App\Models\User;
use App\Models\Department;
use PHPUnit\TextUI\XmlConfiguration\SchemaFinder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::where('role','staff')->delete();
        DB::table('staff')->truncate();
        Schema::enableForeignKeyConstraints();

        $staffData = [
            [
                'name' => 'Prof. David Chen',
                'email' => 'david.chen@college.com',
                'employee_id' => 'E-101',
                'designation' => 'Professor',
                'department_code' => 'CSE',
                'hire_date' => '2018-08-01',
                'role'=>'staff'
            ],
            [
                'name' => 'Dr. Sarah Kim',
                'email' => 'sarah.kim@college.com',
                'employee_id' => 'E-102',
                'designation' => 'Associate Professor',
                'department_code' => 'IT',
                'hire_date' => '2019-05-15',
                'role'=>'staff'
            ],
            [
                'name' => 'Mr. Robert Brown',
                'email' => 'robert.brown@college.com',
                'employee_id' => 'E-103',
                'designation' => 'Lab Technician',
                'department_code' => 'ME',
                'hire_date' => '2021-01-20',
                'role'=>'staff'
            ],
            [
                'name' => 'Dr. Anita Patel',
                'email' => 'anita.patel@college.com',
                'employee_id' => 'E-104',
                'designation' => 'Professor',
                'department_code' => 'ECE',
                'hire_date' => '2017-11-30',
                'role'=>'staff'
            ],
        ];

        foreach($staffData as $staff){
            $department  = Department::where('code',$staff['department_code'])->first();

            $user = User::create([
                'name' => $staff['name'],
                'email' => $staff['email'],
                'password' => Hash::make($staff['password']??'password'),
                'role' => $staff['role'],
            ]);

            $user->staff()->create([
                'department_id' => $department ? $department->id : null,
                'employee_id' => $staff['employee_id'],
                'designation' => $staff['designation'],
                'hire_date'=>$staff['hire_date'],
            ]);
        }
    }
}
