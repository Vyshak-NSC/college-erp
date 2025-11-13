<?php

namespace App\Models;

use App\Models\Program;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name','code','description','credits','semester','program_id'];

    public function getDepartmentAttribute(){
        return $this->program->department;
    }

    public function program(){
        return $this->belongsTo(Program::class);
    }
    
    public function staff(){
        return $this->belongsToMany(Staff::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class)
                    ->withPivot('grade','marks','attendance')
                    ->withTimestamps();
    }
}
