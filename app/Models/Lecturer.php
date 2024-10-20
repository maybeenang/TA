<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    public $fillable = [
        'nip',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
