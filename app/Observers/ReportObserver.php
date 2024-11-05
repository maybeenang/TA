<?php

namespace App\Observers;

use App\Models\Report;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        // create 3 cmpk with loop
        for ($i = 1; $i <= 3; $i++) {
            $report->cpmks()->create([
                'code' => 'CPMK' . $i,
                'description' => 'Competency ' . $i,
                'criteria' => 'Criteria ' . $i,
                'average_score' => 0,
            ]);
        }
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
