<?php

namespace App\Listeners;

use App\Events\GradeComponentUpdated;
use App\Events\StudentGradeUpdated;
use App\Jobs\GenerateReportPDF;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RecalculateGradeComponent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GradeComponentUpdated $event): void
    {
        $stuedentIds = $event->report->grades()->pluck('student_id');

        foreach ($stuedentIds as $studentId) {
            event(new StudentGradeUpdated($studentId, $event->report));
        }
    }
}
