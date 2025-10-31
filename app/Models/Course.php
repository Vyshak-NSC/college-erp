<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name','code','description','credits','department_id','semester'];

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
