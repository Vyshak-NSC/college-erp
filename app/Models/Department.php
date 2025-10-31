<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;

class Department extends Model
{
    protected $fillable = ['name','code','description'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
