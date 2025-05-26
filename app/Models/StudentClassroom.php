<?php

namespace App\Models;

use App\Observers\StudentClassroomObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[ObservedBy(StudentClassroomObserver::class)]
class StudentClassroom extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'students_class_rooms';

    protected $fillable = [
        'student_id',
        'class_room_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function scopeAuthProgramStudi($query)
    {
        return $query->whereHas('classRoom', function ($query) {
            $query->whereHas('course', function ($query) {
                $query->where('program_studi_id', auth()->user()->program_studi_id);
            });
        });
    }
}
