<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Department;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable =['name','code','total_semesters','department_id'];
    
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function courses(){
        return $this->hasMany(Program::class);
    }
}
