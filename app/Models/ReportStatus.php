<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;

class ReportStatus extends Model
{
    use ReportRelatedModel;

    public $fillable = [
        'name',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
