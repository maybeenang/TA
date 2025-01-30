<?php

namespace App\Models;

use App\Observers\ClassRoomObserver;
use App\Services\AcademicYearService;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(ClassRoomObserver::class)]
class ClassRoom extends Model
{
    use SoftDeletes;

    public $fillable = [
        'id',
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

    public function studentClassrooms()
    {
        return $this->hasMany(StudentClassroom::class);
    }

    public function scopeAuthProgramStudi($query)
    {
        return $query->whereHas('course', function ($query) {
            $query->where('program_studi_id', auth()->user()->program_studi_id);
        });
    }

    public function scopeCurrentAcademicYear($query)
    {
        return $query->where('academic_year_id', app(AcademicYearService::class)->getCurrentAcademicYear()->id);
    }

    public function getFullNameAttribute()
    {
        return $this?->course?->code . ' ' . $this->course?->name . ' ' . $this->name;
    }
}
