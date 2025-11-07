<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $fillable =[
        'user_id',
        'program_id',
        'reg_no',
        'admission_date'
    ];

    public function department(){
        return $this->belongsTo(Department::class, 'program_id');
    }

    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function courses(){
        return $this->belongsToMany(Course::class);
    }
}
