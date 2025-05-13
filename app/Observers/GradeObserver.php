<?php

namespace App\Observers;

use App\Models\Grade;
use App\Models\StudentGrade;
use Illuminate\Support\Facades\Log;

class GradeObserver
{
    public $afterCommit = true;
    /**
     * Handle the Grade "created" event.
     */
    public function created(Grade $grade): void
    {
        /* $grade->report->gradeComponents->each(function ($gradeComponent) use ($grade) { */
        /*     $grade->studentGrades()->create([ */
        /*         'grade_component_id' => $gradeComponent->id, */
        /*     ]); */
        /* }); */

        // get all gradeComponents ID
        $gradeComponentIds = $grade->report->gradeComponents->pluck('id')->toArray();

        $grade->studentGrades()->createMany(
            array_map(function ($gradeComponentId) use ($grade) {
                return [
                    'grade_component_id' => $gradeComponentId,
                    'score' => 0,
                ];
            }, $gradeComponentIds)
        );
    }

    /**
     * Handle the Grade "updated" event.
     */
    public function updated(Grade $grade): void
    {
        //
    }

    /**
     * Handle the Grade "deleted" event.
     */
    public function deleted(Grade $grade): void
    {
        //
    }

    /**
     * Handle the Grade "restored" event.
     */
    public function restored(Grade $grade): void
    {
        //
    }

    /**
     * Handle the Grade "force deleted" event.
     */
    public function forceDeleted(Grade $grade): void
    {
        //
    }
}
