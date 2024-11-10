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

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
