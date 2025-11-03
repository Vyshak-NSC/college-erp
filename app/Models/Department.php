<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Program;

class Department extends Model
{
    protected $fillable = ['name','code','description'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function programs(){
        return $this->hasMany(Program::class);
    }
    
    public function courses(){
        return $this->hasManyThrough(Course::class, Program::class);
    }

    public function staff(){
        return $this->hasMany(Staff::class);
    }
}
