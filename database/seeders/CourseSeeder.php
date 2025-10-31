<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->truncate();
        $courses = [
            // Computer Science (CSE)
            ['name' => 'Introduction to Programming', 'code' => 'CSE101', 'description' => 'Basics of programming using Python.', 'credits' => 4, 'department_code' => 'CSE'],
            ['name' => 'Data Structures', 'code' => 'CSE201', 'description' => 'Fundamental data structures and algorithms.', 'credits' => 4, 'department_code' => 'CSE'],
            ['name' => 'Database Systems', 'code' => 'CSE305', 'description' => 'Relational database design and SQL.', 'credits' => 3, 'department_code' => 'CSE'],

            // Information Technology (IT)
            ['name' => 'Web Development Fundamentals', 'code' => 'IT110', 'description' => 'Introduction to HTML, CSS, and JavaScript.', 'credits' => 3, 'department_code' => 'IT'],
            ['name' => 'Network Security', 'code' => 'IT350', 'description' => 'Principles of network security and cryptography.', 'credits' => 3, 'department_code' => 'IT'],

            // Mechanical Engineering (ME)
            ['name' => 'Thermodynamics', 'code' => 'ME210', 'description' => 'Laws of thermodynamics and energy conversion.', 'credits' => 4, 'department_code' => 'ME'],
            ['name' => 'Mechanical Design I', 'code' => 'ME310', 'description' => 'Design and analysis of machine components.', 'credits' => 3, 'department_code' => 'ME'],

            // Electronics and Communication (ECE) - NEW
            ['name' => 'Electronic Circuits', 'code' => 'ECE101', 'description' => 'Analysis and design of electronic circuits.', 'credits' => 4, 'department_code' => 'ECE'],
            ['name' => 'Signals and Systems', 'code' => 'ECE201', 'description' => 'Analysis of continuous and discrete-time signals.', 'credits' => 4, 'department_code' => 'ECE'],
            ['name' => 'Communication Systems', 'code' => 'ECE301', 'description' => 'Principles of analog and digital communication.', 'credits' => 3, 'department_code' => 'ECE'],
        ];

        foreach($courses as $course){
            $department = Department::where('code',$course['department_code'])->first();

            if($department){
                Course::updateOrCreate(
                    ['code' => $course['code']],
                    [
                        'name'=>$course['name'],
                        'description'=>$course['description'],
                        'credits'=>$course['credits'],
                        'department_id'=>$department->id,
                    ]
                );
            }else{
                $this->command->warn("Skipping course '{$course['name']}' : Department code '{$course['department_code']}' not found.");
            }
        }
    }
}
