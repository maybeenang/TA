<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    public $fillable = [
        'report_status_id',
        'content',
        'notes',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function reportStatus()
    {
        return $this->belongsTo(ReportStatus::class);
    }
}
