<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
    ];


    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
