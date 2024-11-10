<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeScale extends Model
{
    protected $table = 'grading_scale';
    protected $fillable = [
        'report_id',
        'min_score',
        'max_score',
        'letter',
    ];

    // convert the max_score to 100
    public function getMaxScoreAttribute($value)
    {
        return $value * 100;
    }

    // convert the min_score to 100
    public function getMinScoreAttribute($value)
    {
        return $value * 100;
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
