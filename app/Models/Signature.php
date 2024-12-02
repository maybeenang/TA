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

    public function reportsgkmp()
    {
        return $this->hasMany(Report::class, 'signature_gkmp_id');
    }

    public function reportskaprodi()
    {
        return $this->hasMany(Report::class, 'signature_kaprodi_id');
    }
}
