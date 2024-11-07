<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function gradeComponent()
    {
        return $this->belongsTo(GradeComponent::class);
    }
}
