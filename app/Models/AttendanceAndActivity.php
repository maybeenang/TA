<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceAndActivity extends Model
{
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
