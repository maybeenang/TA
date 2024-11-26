<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class AcademicYear extends Model
{
    use SoftDeletes, HasFactory;

    public $fillable = [
        'name',
        'semester',
        'start_date',
        'end_date',
    ];

    protected static function booted()
    {
        // Hapus cache ketika ada perubahan data
        static::saved(function () {
            Cache::forget('current_academic_year');
            Cache::forget('all_academic_years');
        });
    }


    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->semester}";
    }
}
