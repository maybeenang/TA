<?php

namespace App\Models;

use App\Observers\ReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

#[ObservedBy(ReportObserver::class)]
class Report extends Model
{
    use SoftDeletes;

    public $fillable = [
        'report_status_id',
        'responsible_lecturer',
        'teaching_methods',
        'self_evaluation',
        'follow_up_plan',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function reportStatus()
    {
        return $this->belongsTo(ReportStatus::class);
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'report_lecturers');
    }

    public function cpmks()
    {
        return $this->hasMany(Cpmk::class);
    }

    public function attendanceAndActivities()
    {
        return $this->hasMany(AttendanceAndActivity::class);
    }

    public function quistionnaires()
    {
        return $this->hasMany(Quistionnaire::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function gradeComponents()
    {
        return $this->hasMany(GradeComponent::class);
    }

    public function gradeScales()
    {
        return $this->hasMany(GradeScale::class);
    }

    public function progres()
    {
        $informasiUmum = $this->responsible_lecturer !== null && $this->lecturers->count() > 0;

        $metodePerkuliahan = $this->teaching_methods !== null && $this->self_evaluation !== null && $this->follow_up_plan !== null;

        $metodeEvaluasi = $this->cpmks()->each(function ($cpmk) {
            return $cpmk->code !== null && $cpmk->description !== null && $cpmk->criteria !== null && $cpmk->average_score !== null;
        });


        $presensiDanKeaktifan = $this->attendanceAndActivities()->each(function ($attendanceAndActivity) {
            return $attendanceAndActivity->attendance !== null && $attendanceAndActivity->activity !== null;
        });

        $kriteriaPenilaian = $this->gradeComponents->count() > 0 && $this->gradeScales->count() > 0;

        $penilaianMahasiswa = $this->grades->count() > 0;

        $kuisioner = $this->quistionnaires->count() > 0;

        return compact(
            'informasiUmum',
            'metodePerkuliahan',
            'metodeEvaluasi',
            'presensiDanKeaktifan',
            'kriteriaPenilaian',
            'penilaianMahasiswa',
            'kuisioner',
        );
    }
}
