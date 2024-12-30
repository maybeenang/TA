<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'program_studi_id',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'students_class_rooms');
    }

    public function studentClassrooms()
    {
        return $this->hasMany(StudentClassroom::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
