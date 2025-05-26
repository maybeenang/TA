<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Setting extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'key',
        'name',
        'is_shown',
        'program_studi_id',
        'last_updated_by',
        'last_synced_by',
        'last_updated_at',
        'last_synced_at',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
        'last_updated_at' => 'datetime',
    ];

    public function userLastUpdate()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    public function userLastSync()
    {
        return $this->belongsTo(User::class, 'last_synced_by');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}
