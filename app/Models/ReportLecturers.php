<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;

class ReportLecturers extends Model
{

    use ReportRelatedModel;

    protected $table = 'report_lecturers';

    public $fillable = [
        'report_id',
        'lecturer_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
