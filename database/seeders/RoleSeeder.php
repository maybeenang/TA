<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $lecture = Role::create(['name' => 'lecture']);

        $users = User::get();

        /*chec if user is not empty*/
        if ($users->isNotEmpty()) {
            $users->each(function ($user) use ($lecture) {
                $user->assignRole($lecture);
            });

            // Assign admin to user who have email contain admin
            $users->filter(function ($user) {
                return str_contains($user->email, 'admin');
            })->each(function ($user) use ($admin) {
                $user->assignRole($admin);
            });
        }
    }
}
