<?php

namespace App\Traits;

use App\Services\AcademicYearService;

trait WithAcademicYear
{
    public $currentAcademicYear;
    public $academicYearId;

    public function bootWithAcademicYear(AcademicYearService $service)
    {
        $this->currentAcademicYear = $service->getCurrentAcademicYear();
        $this->academicYearId = $this->currentAcademicYear->id;
    }
}
