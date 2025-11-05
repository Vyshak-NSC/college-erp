<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Program;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [

            // B.Tech CSE
            ['name'=>'Intro to Programming',     'code'=>'CSE101', 'credits'=>4, 'semester'=>1, 'description'=>'Basics of coding',                    'program_code'=>'BTECH_CSE'],
            ['name'=>'Data Structures',          'code'=>'CSE202', 'credits'=>4, 'semester'=>3, 'description'=>'Stacks / Queues / Trees',           'program_code'=>'BTECH_CSE'],
            ['name'=>'Operating Systems',        'code'=>'CSE301', 'credits'=>3, 'semester'=>5, 'description'=>'OS Concepts',                       'program_code'=>'BTECH_CSE'],

            // M.Tech CSE
            ['name'=>'Advanced Algorithms',      'code'=>'MCSE501','credits'=>3, 'semester'=>1, 'description'=>'Advanced algo theory',               'program_code'=>'MTECH_CSE'],

            // B.Tech IT
            ['name'=>'Web Development',          'code'=>'IT110',  'credits'=>3, 'semester'=>2, 'description'=>'HTML CSS JS',                       'program_code'=>'BTECH_IT'],
            ['name'=>'Networks',                 'code'=>'IT210',  'credits'=>3, 'semester'=>3, 'description'=>'Computer Networks basics',          'program_code'=>'BTECH_IT'],

            // Diploma IT
            ['name'=>'Office Automation',        'code'=>'DIPIT01','credits'=>2, 'semester'=>1, 'description'=>'Docs Excel Powerpoint',             'program_code'=>'DIP_IT'],

            // B.Tech ME
            ['name'=>'Thermodynamics',           'code'=>'ME210',  'credits'=>4, 'semester'=>3, 'description'=>'Thermo concepts',                   'program_code'=>'BTECH_ME'],

            // B.Tech ECE
            ['name'=>'Electronic Circuits',      'code'=>'ECE101', 'credits'=>4, 'semester'=>1, 'description'=>'Analog electronics',                'program_code'=>'BTECH_ECE'],
            ['name'=>'Signals and Systems',      'code'=>'ECE201', 'credits'=>4, 'semester'=>3, 'description'=>'Signal Analysis',                   'program_code'=>'BTECH_ECE'],

            // M.Tech VLSI
            ['name'=>'VLSI Design',              'code'=>'VLSI501','credits'=>3, 'semester'=>1, 'description'=>'VLSI Basics',                       'program_code'=>'MTECH_VLSI'],

            // B.Tech CE
            ['name'=>'Structural Analysis',      'code'=>'CE101',  'credits'=>3, 'semester'=>1, 'description'=>'Structures basics',                 'program_code'=>'BTECH_CE'],
        ];

        foreach($courses as $c){

            $program = Program::where('code',$c['program_code'])->first();

            if(!$program){
                $this->command?->warn("SKIP {$c['code']} no program {$c['program_code']}");
                continue;
            }

            Course::updateOrCreate(
                ['code'=>$c['code']],
                [
                    'name'=>$c['name'],
                    'description'=>$c['description'],
                    'credits'=>$c['credits'],
                    'semester'=>$c['semester'],
                    'program_id'=>$program->id,
                ]
            );
        }
    }
}
