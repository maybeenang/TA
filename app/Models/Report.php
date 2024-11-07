<?php

namespace App\Models;

use App\Observers\ReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(ReportObserver::class)]
class Report extends Model
{
    use SoftDeletes;

    public $fillable = [
        'report_status_id',
        'responsible_lecturer',
        'teaching_methods',
        'self_evaluation',
        'follow_up_plan',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function reportStatus()
    {
        return $this->belongsTo(ReportStatus::class);
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'report_lecturers');
    }

    public function cpmks()
    {
        return $this->hasMany(Cpmk::class);
    }

    public function attendanceAndActivities()
    {
        return $this->hasMany(AttendanceAndActivity::class);
    }

    public function quistionnaires()
    {
        return $this->hasMany(Quistionnaire::class);
    }

    public function gradeComponents()
    {
        return $this->hasMany(GradeComponent::class);
    }
}
