<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{

    protected $fillable = [
        'path',
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
