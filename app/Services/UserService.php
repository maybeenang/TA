<?php

namespace App\Services;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => bcrypt($data['password']),
                'program_studi_id' => $data['programStudi'],
            ]);

            $user->assignRole($data['roles']);

            $user->lecturer()->create([
                'nip' => $data['nip'],
            ]);

            return $user;
        });
    }

    public function update(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $user->update([
                'email' => $data['email'],
                'name' => $data['name'],
                'program_studi_id' => $data['programStudi'],
            ]);

            $user->syncRoles($data['roles']);

            $user->lecturer()->update([
                'nip' => $data['nip'],
            ]);

            return $user;
        });
    }
}
