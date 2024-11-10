<?php

namespace App\Observers;

use App\Models\GradeComponent;
use Illuminate\Support\Facades\Log;

class GradeComponentObserver
{
    /**
     * Handle the GradeComponent "created" event.
     */
    public function created(GradeComponent $gradeComponent): void
    {
        $gradeComponent->report->grades->each(function ($grade) use ($gradeComponent) {
            $grade->studentGrades()->create([
                'grade_component_id' => $gradeComponent->id,
            ]);
        });
    }

    /**
     * Handle the GradeComponent "updated" event.
     */
    public function updated(GradeComponent $gradeComponent): void
    {
        //
    }

    /**
     * Handle the GradeComponent "deleted" event.
     */
    public function deleted(GradeComponent $gradeComponent): void
    {
        //
    }

    /**
     * Handle the GradeComponent "restored" event.
     */
    public function restored(GradeComponent $gradeComponent): void
    {
        //
    }

    /**
     * Handle the GradeComponent "force deleted" event.
     */
    public function forceDeleted(GradeComponent $gradeComponent): void
    {
        //
    }
}
