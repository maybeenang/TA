<?php

namespace App\Models;

use App\Enums\ReportStatusEnum;
use App\Observers\ReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[ObservedBy(ReportObserver::class)]
class Report extends Model
{
    use SoftDeletes, HasUuids;

    public $fillable = [
        'report_status_id',
        'responsible_lecturer',
        'teaching_methods',
        'self_evaluation',
        'follow_up_plan',
        'class_room_id',
        'pdf_path',
        'pdf_status',
        'note',
        'verified_at',
        'signature_gkmp_id',
        'signature_kaprodi_id',
        'verifikator_gkmp',
        'verifikator_kaprodi',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];


    public function getUserIdAttribute()
    {
        return $this->classRoom?->lecturer?->user?->id ?? null;
    }


    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function responsibleLecturer()
    {
        return $this->belongsTo(Lecturer::class, 'responsible_lecturer');
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

    public function signatureGkmp()
    {
        return $this->belongsTo(Signature::class, 'signature_gkmp_id');
    }

    public function signatureKaprodi()
    {
        return $this->belongsTo(Signature::class, 'signature_kaprodi_id');
    }

    public function progres()
    {
        $informasiUmum = $this->responsible_lecturer !== null && $this->lecturers->count() > 0;

        $metodePerkuliahan = $this->teaching_methods !== null && $this->self_evaluation !== null && $this->follow_up_plan !== null;

        $metodeEvaluasi = $this->cpmks()->each(function ($cpmk) {
            return $cpmk->code !== null && $cpmk->description !== null && $cpmk->criteria !== null && $cpmk->average_score !== null;
        });

        $presensiDanKeaktifan = $this->attendanceAndActivities()->each(function ($attendanceAndActivity) {
            return $attendanceAndActivity->student_present !== null && $attendanceAndActivity->student_active !== null;
        });

        $kriteriaPenilaian = $this->gradeComponents->count() > 0 && $this->gradeScales->count() > 0;

        $penilaianMahasiswa = $this->grades()->each(function ($grade) {
            return $grade->letter !== null;
        });


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

    public function getStandarDeviationAttribute()
    {

        try {
            $scores = $this->grades->pluck('total_score');
            $count = $scores->count();
            $sum = $scores->sum();
            $squaredSum = $scores->map(function ($score) {
                return pow($score, 2);
            })->sum();

            $variance = ($squaredSum - ($sum ** 2) / $count) / ($count - 1);
            return round(sqrt($variance), 2);
        } catch (\DivisionByZeroError $e) {
            return 0;
        } catch (\Error $e) {
            return 0;
        }
    }

    public function convertToGradeScale($score)
    {
        $gradeScale = $this->gradeScales->first(function ($gradeScale) use ($score) {

            $score = round($score);

            // check if score is between min and max score
            if ($score >= $gradeScale->min_score && $score <= $gradeScale->max_score) {
                return $gradeScale;
            }

            // check if score is equal to min score
            if ($score === $gradeScale->min_score) {
                return $gradeScale;
            }

            // check if score is equal to max score
            if ($score === $gradeScale->max_score) {
                return $gradeScale;
            }

            return $score >= $gradeScale->min_score && $score <= $gradeScale->max_score;
        });

        if (!$gradeScale) {
            $highestGradeScale = $this->gradeScales->sortByDesc('max_score')->first();
            $lowestGradeScale = $this->gradeScales->sortBy('min_score')->first();

            if ($score >= $highestGradeScale->max_score) {
                $gradeScale = $highestGradeScale;
            }

            if ($score <= $lowestGradeScale->min_score) {
                $gradeScale = $lowestGradeScale;
            }
        }

        return $gradeScale;
    }

    public function hasRelationChanges(array $relations): bool
    {
        return collect($relations)->some(function ($relation) {
            return $this->wasRecentlyCreated ||
                $this->isDirty() ||
                $this->isRelationChanged($relation);
        });
    }

    protected function isRelationChanged(string $relation): bool
    {
        if (!$this->relationLoaded($relation)) {
            return false;
        }

        $originalRelation = $this->getOriginal($relation);
        $currentRelation = $this->$relation;

        return $originalRelation != $currentRelation;
    }


    public function verifikasiData()
    {
        $reportStatus = $this->reportStatus->name;

        if ($reportStatus !== ReportStatusEnum::TERVERIFIKASI->value) {
            // return collection
            return (object)[
                'kaprodi' => '-',
                'kaprodiNip' => '-',
                'gkmp' => '-',
                'gkmpNip' => '-',
            ];
        }

        $verifikatorGkmp = User::find($this->verifikator_gkmp);
        $verifikatorKaprodi = User::find($this->verifikator_kaprodi);

        // return object
        return (object)[
            'kaprodi' => $verifikatorKaprodi->name ?? '-',
            'kaprodiNip' => $verifikatorKaprodi->lecturer->nip ?? '-',
            'gkmp' => $verifikatorGkmp->name ?? '-',
            'gkmpNip' => $verifikatorGkmp->lecturer->nip ?? '-',
            'verified_at' => $this?->verified_at ?? now(),
            'signatureGkmp' => $this?->signatureGkmp?->path ?? null,
            'signatureKaprodi' => $this?->signatureKaprodi?->path ?? null,
        ];
    }

    public function getIsEditableAttribute()
    {
        return $this->reportStatus->name === ReportStatusEnum::DRAFT->value || $this->reportStatus->name === ReportStatusEnum::DITOLAK->value;
    }
}
