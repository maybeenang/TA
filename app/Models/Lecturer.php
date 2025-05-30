<?php

namespace App\Models;

use App\Traits\ReportRelatedModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Lecturer extends Model
{
    use SoftDeletes, ReportRelatedModel, HasUuids;

    public $fillable = [
        'nip',
        'user_id',
    ];

    protected $casts = [
        'nip' => 'string',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function reports()
    {
        return $this->belongsToMany(Report::class, 'report_lecturers');
    }
}
