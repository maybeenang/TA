<?php

namespace App\Models;

use App\Observers\GradeComponentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(GradeComponentObserver::class)]
class GradeComponent extends Model
{

    protected $fillable = [
        'report_id',
        'name',
        'weight',
    ];

    // convert weight to percentage
    public function getWeightAttribute($value)
    {
        $value = $value * 100;
        return $value . '%';
    }

    public function getWeightRawAttribute()
    {
        return $this->attributes['weight'];
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function standardDeviation()
    {
        $scores = $this->studentGrades->pluck('score');
        $mean = $scores->avg();
        $count = $scores->count();
        $sum = $scores->sum();
        $squaredSum = $scores->map(function ($score) {
            return pow($score, 2);
        })->sum();
        $variance = ($squaredSum - ($sum ** 2) / $count) / ($count - 1);
        return sqrt($variance);
    }
}
