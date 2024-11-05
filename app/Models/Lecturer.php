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
        return $this->hasMany(ClassRoom::class);
    }

    public function reports()
    {
        return $this->belongsToMany(Report::class, 'report_lecturers');
    }
}
