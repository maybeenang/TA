<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
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
