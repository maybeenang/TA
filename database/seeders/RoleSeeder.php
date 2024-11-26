<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*$admin = Role::create(['name' => 'admin']);*/
        /*$lecture = Role::create(['name' => 'tenaga-pengajar']);*/

        $admin = app(Role::class)->findOrCreate(RolesEnum::ADMIN->value, 'web');
        $tenagaPengajar = app(Role::class)->findOrCreate(RolesEnum::TENAGAPENGAJAR->value, 'web');

        $users = User::get();

        /*chec if user is not empty*/
        if ($users->isNotEmpty()) {
            $users->each(function ($user) use ($tenagaPengajar) {
                $user->assignRole($tenagaPengajar);
            });

            // Assign admin to user who have email contain admin
            $users->filter(function ($user) {
                return str_contains($user->email, 'admin');
            })->each(function ($user) use ($admin) {
                $user->assignRole($admin);
            });
        }

        $me = User::where('email', 'elangpermadani123@gmail.com')->first();

        if ($me) {
            $me->assignRole($tenagaPengajar);
        }
    }
}
