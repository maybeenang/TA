<?php

namespace App\Listeners;

use App\Events\StudentGradeUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RecalculateStudentGrade
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
    public function handle(StudentGradeUpdated $event): void
    {

        $gradeComponents = $event->report->gradeComponents;
        $studentGrades = $event->report->grades()->where('student_id', $event->student->id)->first()->studentGrades;

        $totalScore = 0;

        foreach ($gradeComponents as $gradeComponent) {
            $studentGrade = $studentGrades->firstWhere('grade_component_id', $gradeComponent->id);
            $totalScore += $studentGrade->score * $gradeComponent->getRawOriginal('weight');
        }

        // update the grade
        $event->report->grades()->where('student_id', $event->student->id)->update([
            'total_score' => $totalScore,
            'letter' => $event->report->convertToGradeScale($totalScore)?->letter ?? '-',
        ]);
    }
}
