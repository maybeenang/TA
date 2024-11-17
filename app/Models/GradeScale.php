<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;

class GradeScale extends Model
{

    use ReportRelatedModel;
    protected $table = 'grading_scale';
    protected $fillable = [
        'report_id',
        'min_score',
        'max_score',
        'letter',
        'score',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
