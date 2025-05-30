<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AttendanceAndActivity extends Model
{

    use ReportRelatedModel, HasUuids;
    //
    protected $table = 'attendance_and_activity';

    protected $fillable = [
        'report_id',
        'week',
        'meeting_name',
        'student_present',
        'student_active',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
