<?php

namespace App\Models;

use App\Observers\GradeObserver;
use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


#[ObservedBy(GradeObserver::class)]
class Grade extends Model
{

    use ReportRelatedModel, HasUuids;
    //
    protected $fillable = [
        'student_id',
        'class_room_id',
        'report_id',
        'letter',
        'total_score'
    ];

    public function getTotalScoreAttribute($value)
    {
        return (int) $value == $value ? number_format($value, 0) : number_format($value, 2);
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
