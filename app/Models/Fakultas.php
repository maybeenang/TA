<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fakultas extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function programStudis()
    {
        return $this->hasMany(ProgramStudi::class);
    }
}
