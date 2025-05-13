<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use SoftDeletes, HasFactory;


    protected static function booted()
    {
        static::created(function (ProgramStudi $programStudi) {
            $default = [
                ['key' => 'tahun_akademik', 'name' => 'Tahun Akademik', 'is_shown' => true,],
                ['key' => 'pengguna', 'name' => 'Pengguna', 'is_shown' => true,],
                ['key' => 'kelas', 'name' => 'Kelas', 'is_shown' => true,],
                ['key' => 'mahasiswa', 'name' => 'Mahasiswa', 'is_shown' => true,],
            ];

            $programStudi->settings()->createMany($default);
        });
    }

    protected $fillable = [
        'name',
        'fakultas_id',
    ];


    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
}
