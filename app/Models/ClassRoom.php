<?php

namespace App\Models;

use App\Observers\ClassRoomObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(ClassRoomObserver::class)]
class ClassRoom extends Model
{
    use SoftDeletes;

    public $fillable = [
        'name',
        'schedule',
        'mode',
        'course_id',
        'lecturer_id',
        'academic_year_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'students_class_rooms');
    }

    public function getFullNameAttribute()
    {
        return $this?->course?->code . ' ' . $this->course?->name . ' ' . $this->name;
    }
}
