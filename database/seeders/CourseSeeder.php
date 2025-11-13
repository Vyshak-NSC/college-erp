<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Support\Facades\Schema;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Course::truncate();
        Schema::enableForeignKeyConstraints();

        $baseCourses = [
            1 => ['Intro to Programming', 'Mathematics I', 'Physics Fundamentals', 'Basic Electrical'],
            2 => ['Data Structures', 'Discrete Mathematics', 'Digital Logic', 'Professional Communication'],
            3 => ['Algorithms', 'Database Systems', 'Computer Networks', 'Operating Systems'],
            4 => ['Microprocessors', 'Software Engineering', 'Probability & Statistics', 'Web Development'],
            5 => ['Compiler Design', 'Machine Learning', 'Cloud Computing', 'Computer Graphics'],
            6 => ['Cyber Security', 'IoT Systems', 'Mobile Computing', 'AI Applications'],
            7 => ['Data Mining', 'Distributed Systems', 'Big Data Analytics', 'Deep Learning'],
            8 => ['Project Work', 'Seminar', 'Internship', 'Research Methodology'],
        ];

        $mtechCourses = [
            1 => ['Advanced Algorithms', 'Research Methodology', 'High Performance Computing', 'Advanced DBMS'],
            2 => ['Deep Learning', 'Advanced Networking', 'Data Mining', 'Advanced OS'],
            3 => ['Seminar', 'Elective I', 'Elective II'],
            4 => ['Thesis Work', 'Publication Seminar'],
        ];

        $programs = Program::all();

        foreach ($programs as $program) {
            $totalSemesters = $program->total_semesters;
            $courseSet = str_contains($program->code, 'MTECH') ? $mtechCourses : $baseCourses;

            for ($sem = 1; $sem <= $totalSemesters; $sem++) {
                if (!isset($courseSet[$sem])) continue;
                foreach ($courseSet[$sem] as $index => $name) {
                    $code = strtoupper($program->code . str_pad($sem, 2, '0', STR_PAD_LEFT) . str_pad($index + 1, 2, '0', STR_PAD_LEFT));
                    Course::updateOrCreate(
                        ['code' => $code],
                        [
                            'name' => $name,
                            'description' => "$name for {$program->name}",
                            'credits' => rand(2, 4),
                            'semester' => $sem,
                            'program_id' => $program->id,
                        ]
                    );
                }
            }
        }
    }
}
