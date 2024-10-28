<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStatus extends Model
{
    public $fillable = [
        'name',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
