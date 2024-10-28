<?php

namespace App\Observers;

use App\Models\ClassRoom;

class ClassRoomObserver
{
    /**
     * Handle the ClassRoom "created" event.
     */
    public function created(ClassRoom $classRoom): void
    {
        $classRoom->report()->create(
            [
                'report_status_id' => 1,
            ]
        );
    }

    /**
     * Handle the ClassRoom "updated" event.
     */
    public function updated(ClassRoom $classRoom): void
    {
        //
    }

    /**
     * Handle the ClassRoom "deleted" event.
     */
    public function deleted(ClassRoom $classRoom): void
    {
        //
    }

    /**
     * Handle the ClassRoom "restored" event.
     */
    public function restored(ClassRoom $classRoom): void
    {
        //
    }

    /**
     * Handle the ClassRoom "force deleted" event.
     */
    public function forceDeleted(ClassRoom $classRoom): void
    {
        //
    }
}
