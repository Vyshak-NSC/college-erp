<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class 
Student extends Model
{
    protected $fillable =[
        'user_id',
        'program_id',
        'reg_no',
        'admission_date'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
public function department() {
    return $this->hasOneThrough(
        Department::class, // final model
        Program::class,    // intermediate model
        'id',              // foreign key on Program (Program.id)
        'id',              // foreign key on Department (Department.id)
        'program_id',      // local key on Student (Student.program_id)
        'department_id'    // local key on Program (Program.department_id)
    );
}


    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function courses(){
        return $this->belongsToMany(Course::class)
                    ->withPivot('grade','marks','attendance')
                    ->withTimestamps();
    }

    protected function cgpa() : Attribute{
        return Attribute::make(
            get: function(){
                $results = $this->courses;

                if($results->isEmpty()){
                    return 0;
                }

                $totalPoints = 0;
                $totalCredits = 0;

                foreach($results as $result){
                    $credits += $result->credits;
                    $points = $this->getPointFromGrade($result->pivot->grade);

                    $totalCredits += $credits;
                    $totalPoints += ($points * $credits);
                }

                if($totalCredits==0){
                    return 0;
                }

                return round($totalPoints/$totalCredits,2);
            }
        );
    }

    private function getPointFromGrade($grade){
        switch($grade){
            case 'A+': return 10.0;
            case 'A': return 9.0;
            case 'B+': return 8.0;
            case 'B': return 7.0;
            case 'C': return 6.0;
            case 'D': return 5.0;
            case 'F': return 0.0;
            default : return 0.0;
        }
    }
}
