<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Department;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [

            // CSE dept
            ['name'=>'B.Tech Computer Science',     'code'=>'BTECH_CSE', 'total_semesters'=>8, 'department_code'=>'CSE'],
            ['name'=>'M.Tech Computer Science',     'code'=>'MTECH_CSE', 'total_semesters'=>4, 'department_code'=>'CSE'],

            // IT dept
            ['name'=>'B.Tech Information Tech',     'code'=>'BTECH_IT',  'total_semesters'=>8, 'department_code'=>'IT'],
            ['name'=>'Diploma in Information Tech', 'code'=>'DIP_IT',     'total_semesters'=>6, 'department_code'=>'IT'],

            // ME dept
            ['name'=>'B.Tech Mechanical Engg',      'code'=>'BTECH_ME',  'total_semesters'=>8, 'department_code'=>'ME'],

            // ECE dept
            ['name'=>'B.Tech Electronics & Comm',   'code'=>'BTECH_ECE', 'total_semesters'=>8, 'department_code'=>'ECE'],
            ['name'=>'M.Tech VLSI',                 'code'=>'MTECH_VLSI','total_semesters'=>4, 'department_code'=>'ECE'],

            // CE dept
            ['name'=>'B.Tech Civil Engineering',    'code'=>'BTECH_CE',  'total_semesters'=>8, 'department_code'=>'CE'],
        ];

        foreach($programs as $p) {

            $dept = Department::where('code',$p['department_code'])->first();

            if(!$dept){
                $this->command?->warn("SKIP {$p['code']} no dept {$p['department_code']}");
                continue;
            }

            Program::updateOrCreate(
                ['code'=>$p['code']],
                [
                    'name'=>$p['name'],
                    'total_semesters'=>$p['total_semesters'],
                    'department_id'=>$dept->id,
                ]
            );
        }
    }
}
