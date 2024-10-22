<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecturer extends Model
{
    use SoftDeletes;

    public $fillable = [
        'nip',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function classRooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'lecturer_teaches', 'lecturer_id', 'class_room_id')
            ->withPivot('academic_year_id')
            ->withTimestamps();
    }
}
