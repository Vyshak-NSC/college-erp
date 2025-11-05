<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Computer Science', 'code' => 'CSE', 'description' => 'Department of Computer Science and Engineering'],
            ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'IT and Systems Department'],
            ['name' => 'Mechanical Engineering', 'code' => 'ME', 'description' => 'Mechanical and Industrial Systems'],
            ['name' => 'Electrical Engineering', 'code' => 'EE', 'description' => 'Electrical and Electronics'],
            ['name' => 'Civil Engineering', 'code' => 'CE', 'description' => 'Civil and Environmental Studies'],
            ['name' => 'Electronics and Communications Engineering', 'code' => 'ECE', 'description' => 'Electronics and Communication Studies'],
        ];

        foreach($departments as $department){
            Department::updateOrCreate(
                ['code' => $department['code']],
                $department
            );
        }
    }
}
