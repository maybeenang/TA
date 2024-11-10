<?php

namespace App\Models;

use App\Observers\StudentClassroomObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(StudentClassroomObserver::class)]
class StudentClassroom extends Model
{
    use HasFactory;

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
}
