<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    public $fillable = [];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
}
