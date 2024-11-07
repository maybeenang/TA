<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    //
    protected $fillable = [
        'student_id',
        'class_room_id',
        'report_id',
        'total_score'
    ];



    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
