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

        // get all grade scale
        $gradingScales = $event->report->gradeScales;

        // get the grade scale that match the total score
        $gradeScale = $gradingScales->first(function ($gradingScale) use ($totalScore) {
            return $totalScore >= $gradingScale->min_score && $totalScore <= $gradingScale->max_score;
        });

        // check if the grade scale too high or too low
        if (!$gradeScale) {
            // get higest and lowest grade scale
            $highestGradeScale = $gradingScales->sortByDesc('max_score')->first();
            $lowestGradeScale = $gradingScales->sortBy('min_score')->first();

            // check if the total score is higher than the highest grade scale
            if ($totalScore > $highestGradeScale->max_score) {
                $gradeScale = $highestGradeScale;
            }

            // check if the total score is lower than the lowest grade scale

            if ($totalScore < $lowestGradeScale->min_score) {
                $gradeScale = $lowestGradeScale;
            }
        }


        // update the grade
        $event->report->grades()->where('student_id', $event->student->id)->update([
            'total_score' => $totalScore,
            'letter' => $gradeScale->letter,
        ]);
    }
}
