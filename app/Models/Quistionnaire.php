<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quistionnaire extends Model
{
    protected $table = 'quistionnaires';

    protected $fillable = [
        'report_id',
        'statement',
        'strongly_agree',
        'agree',
        'disagree',
        'strongly_disagree',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
