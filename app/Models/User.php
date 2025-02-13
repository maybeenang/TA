<?php

namespace App\Models;


use App\Enums\RolesEnum;
use Duijker\LaravelMercureBroadcaster\Broadcasting\Channel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture_path',
        'program_studi_id',
        'notification_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole(Role::findByName(RolesEnum::ADMIN->value));
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->hasRole(Role::findByName(RolesEnum::SUPERADMIN->value));
    }

    public function getProfilePicturePathAttribute($value)
    {
        return $value ? Storage::url($value) : "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&color=7F9CF5&background=EBF4FF";
    }

    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function scopeAuthProgramStudi($query)
    {
        return $query->where('program_studi_id', auth()->user()->program_studi_id);
    }

    public function updateProfilePhoto($photo)
    {
        $this->deleteProfilePhoto();

        // check if directory exists
        if (!Storage::disk('public')->exists('profile-photos')) {
            Storage::disk('public')->makeDirectory('profile-photos');
        }

        $this->update([
            'profile_picture_path' => $photo->store('profile-photos', 'public'),
        ]);
    }

    public function deleteProfilePhoto()
    {
        if ($this->getRawOriginal('profile_picture_path')) {
            Storage::disk('public')->delete($this->getRawOriginal('profile_picture_path'));
        }
    }
}
