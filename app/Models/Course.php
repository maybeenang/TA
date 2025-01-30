<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, HasFactory;

    public $fillable = [
        'code',
        'name',
        'credit',
        'program_studi_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'id'
    ];

    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function scopeAuthProgramStudi($query)
    {
        return $query->where('program_studi_id', auth()->user()->program_studi_id);
    }

    public function getFullNameAttribute()
    {
        return "{$this->code} {$this->name}";
    }
}
