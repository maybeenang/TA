<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use SoftDeletes, HasFactory;

    public $fillable = [
        'name',
        'start_date',
        'end_date',
    ];


    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }
}
