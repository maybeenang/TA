<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];


    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
