<?php

namespace App\Models;

use App\Observers\GradeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy(GradeObserver::class)]
class Grade extends Model
{
    //
    protected $fillable = [
        'student_id',
        'class_room_id',
        'report_id',
        'total_score'
    ];

    public function getTotalScoreAttribute($value)
    {
        return $value * 100;
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);
    }
}
