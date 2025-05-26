<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Fakultas extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function programStudis()
    {
        return $this->hasMany(ProgramStudi::class);
    }
}
