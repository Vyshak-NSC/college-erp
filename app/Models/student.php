<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Course::class);
    }
}
