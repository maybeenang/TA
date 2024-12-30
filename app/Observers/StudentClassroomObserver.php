<?php

namespace App\Observers;

use App\Models\StudentClassroom;
use Illuminate\Support\Facades\Log;

class StudentClassroomObserver
{
    public $afterCommit = true;

    /**
     * Handle the StudentClassroom "created" event.
     */
    public function created(StudentClassroom $studentClassroom): void
    {
        $studentClassroom->student->grades()->create([
            'class_room_id' => $studentClassroom->class_room_id,
            'report_id' => $studentClassroom->classroom->report->id,
        ]);
    }

    /**
     * Handle the StudentClassroom "updated" event.
     */
    public function updated(StudentClassroom $studentClassroom): void
    {
        //
    }

    /**
     * Handle the StudentClassroom "deleted" event.
     */
    public function deleted(StudentClassroom $studentClassroom): void
    {
        //
    }

    /**
     * Handle the StudentClassroom "restored" event.
     */
    public function restored(StudentClassroom $studentClassroom): void
    {
        //
    }

    /**
     * Handle the StudentClassroom "force deleted" event.
     */
    public function forceDeleted(StudentClassroom $studentClassroom): void
    {
        //
    }
}
