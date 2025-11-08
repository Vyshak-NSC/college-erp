<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
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

        Schema::disableForeignKeyConstraints();
        User::where('role', 'student')->delete();
        DB::table('students')->truncate();
        
        Schema::enableForeignKeyConstraints();
        $studentData = [
            // --- Program 1: B.Tech Computer Science (BTECH_CSE) ---
            ['name' => 'Alice Johnson', 'email' => 'alice.j@college.com', 'reg_no' => 'S2024-001', 'admission_date' => '2024-08-01', 'program_code' => 'BTECH_CSE'],
            ['name' => 'Bob Smith', 'email' => 'bob.s@college.com', 'reg_no' => 'S2024-002', 'admission_date' => '2024-08-01', 'program_code' => 'BTECH_CSE'],
            // --- Program 2: M.Tech Computer Science (MTECH_CSE) ---
            ['name' => 'Carol Williams', 'email' => 'carol.w@college.com', 'reg_no' => 'S2024-003', 'admission_date' => '2024-09-01', 'program_code' => 'MTECH_CSE'],
            
            // --- Program 3: B.Tech Information Tech (BTECH_IT) ---
            ['name' => 'David Brown', 'email' => 'david.b@college.com', 'reg_no' => 'S2024-004', 'admission_date' => '2024-08-01', 'program_code' => 'BTECH_IT'],
            ['name' => 'Eve Davis', 'email' => 'eve.d@college.com', 'reg_no' => 'S2024-005', 'admission_date' => '2024-08-01', 'program_code' => 'BTECH_IT'],
            
            // --- Program 4: Diploma in Information Tech (DIP_IT) ---
            ['name' => 'Frank Miller', 'email' => 'frank.m@college.com', 'reg_no' => 'S2024-006', 'admission_date' => '2024-07-20', 'program_code' => 'DIP_IT'],
            
            // --- Program 5: B.Tech Mechanical Engg (BTECH_ME) ---
            ['name' => 'Grace Wilson', 'email' => 'grace.w@college.com', 'reg_no' => 'S2024-007', 'admission_date' => '2024-08-02', 'program_code' => 'BTECH_ME'],
            ['name' => 'Henry Moore', 'email' => 'henry.m@college.com', 'reg_no' => 'S2024-008', 'admission_date' => '2024-08-02', 'program_code' => 'BTECH_ME'],
            
            // --- Program 6: B.Tech Electronics & Comm (BTECH_ECE) ---
            [ 'name' => 'Ivy Taylor', 'email' => 'ivy.t@college.com', 'reg_no' => 'S2024-009', 'admission_date' => '2024-08-03', 'program_code' => 'BTECH_ECE'],
            [ 'name' => 'Jack Anderson', 'email' => 'jack.a@college.com', 'reg_no' => 'S2024-010', 'admission_date' => '2024-08-03', 'program_code' => 'BTECH_ECE'],
            
            // --- Program 7: M.Tech VLSI (MTECH_VLSI) ---
            [ 'name' => 'Kate Thomas', 'email' => 'kate.t@college.com', 'reg_no' => 'S2024-011', 'admission_date' => '2024-09-02', 'program_code' => 'MTECH_VLSI'],
            // --- Program 8: B.Tech Civil Engineering (BTECH_CE) ---
            [ 'name' => 'Leo Jackson', 'email' => 'leo.j@college.com', 'reg_no' => 'S2024-012', 'admission_date' => '2024-08-01', 'program_code' => 'BTECH_CE'],
            [ 'name' => 'Mia White', 'email' => 'mia.w@college.com', 'reg_no' => 'S2024-013', 'admission_date' => '2024-08-01', 'program_code' => 'BTECH_CE'],
            
            // --- Program 9: B.Tech Electrical Engineering (BTECH_EE) ---
            [ 'name' => 'Noah Harris', 'email' => 'noah.h@college.com', 'reg_no' => 'S2024-014', 'admission_date' => '2024-08-02', 'program_code' => 'BTECH_EE'],
            
            // --- Program 10: M.Tech Electrical Engineering (MTECH_EE) ---
            [ 'name' => 'Olivia Martin', 'email' => 'olivia.m@college.com', 'reg_no' => 'S2024-015', 'admission_date' => '2024-09-01', 'program_code' => 'MTECH_EE'
            ]
        ];
    }
}
