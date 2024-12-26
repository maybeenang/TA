<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $fillable = [
        'name'
    ];

    public function programStudis()
    {
        return $this->hasMany(ProgramStudi::class);
    }
}
