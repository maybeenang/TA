<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    use ReportRelatedModel;
    protected $fillable = [
        'grade_id',
        'grade_component_id',
        'score',
    ];

    public function getScoreAttribute($value)
    {
        return (int) $value == $value ? number_format($value, 0) : number_format($value, 2);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function gradeComponent()
    {
        return $this->belongsTo(GradeComponent::class);
    }

    public function student()
    {
        return $this->grade->student;
    }

    public function totalScore()
    {
        return $this->grade->total_score;
    }
}
