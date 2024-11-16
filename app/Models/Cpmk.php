<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    use ReportRelatedModel;

    protected $fillable = [
        'report_id',
        'code',
        'description',
        'criteria',
        'average_score',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
