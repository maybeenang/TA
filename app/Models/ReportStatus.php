<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ReportStatus extends Model
{
    use ReportRelatedModel, HasUuids;

    public $fillable = [
        'name',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
