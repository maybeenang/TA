<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Quistionnaire extends Model
{
    use ReportRelatedModel, HasUuids;
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

    public function avg($column)
    {
        return round($this->avg($column), 2);
    }
}
