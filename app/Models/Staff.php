<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable =['user_id','name','department_id','program_id','employee_id','designation','hire_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function program(){
        return $this->belongsTo(Program::class);
    }
}
