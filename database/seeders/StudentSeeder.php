<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        Schema::disableForeignKeyConstraints();
        User::where('role', 'student')->delete();
        DB::table('students')->truncate();
        
        Schema::enableForeignKeyConstraints();
        $programSemMap = [
            'BTECH_CSE' => 8,
            'MTECH_CSE' => 4,
            'BTECH_IT'  => 8,
            'DIP_IT'    => 6,
            'BTECH_ME'  => 8,
            'BTECH_ECE' => 8,
            'MTECH_VLSI'=> 4,
            'BTECH_CE'  => 8,
            'BTECH_EE'  => 8,
            'MTECH_EE'  => 4,
        ];

        $studentData = [];

        foreach($programSemMap as $code => $maxSem){
            // generate 10 students per program
            for($i=1;$i<=20;$i++){
                $reg = 'S'.date('Y').'-'.str_pad(rand(1,9999),4,'0',STR_PAD_LEFT);
                $studentData[] = [
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'reg_no' => $faker->unique()->numerify('S'.date('Y').'-####'),
                    'admission_date' => $faker->dateTimeBetween('-1 years'),
                    'semester' => rand(1,$maxSem),
                    'code' => $code,
                ];
            }
        }



        foreach($studentData as $student){
            $program = Program::where('code', $student['code'])->first();

            if (!$program) {
                throw new \Exception("Department with code '{$student['code']}' not found. Staff '{$student['name']}' cannot be created.");
            }

            $user = User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make($student['password'] ?? 'password'),
                'role' => 'student',
            ]);

            $user->student()->create([
                'program_id' => $program->id,
                'semester' => $student['semester'],
                'reg_no' => $student['reg_no'],
                'admission_date' => $student['admission_date']
            ]);
        }
    }
}
