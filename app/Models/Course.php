<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, HasFactory;

    public $fillable = [
        'code',
        'name',
    ];

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'lecturer_courses')
            ->withPivot('academic_year')
            ->withTimestamps();
    }
}
