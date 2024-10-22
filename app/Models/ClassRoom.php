<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassRoom extends Model
{
    use SoftDeletes;

    public $fillable = [
        'name',
        'code',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'lecturer_teaches', 'class_room_id', 'lecturer_id')
            ->withPivot('academic_year_id')
            ->withTimestamps();
    }
}
