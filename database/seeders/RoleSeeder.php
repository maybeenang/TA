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
        $superadmin = app(Role::class)->findOrCreate(RolesEnum::SUPERADMIN->value, 'web');
        $admin = app(Role::class)->findOrCreate(RolesEnum::ADMIN->value, 'web');
        $tenagaPengajar = app(Role::class)->findOrCreate(RolesEnum::TENAGAPENGAJAR->value, 'web');
        $gkmp = app(Role::class)->findOrCreate(RolesEnum::GKMP->value, 'web');
        $kaprodi = app(Role::class)->findOrCreate(RolesEnum::KAPRODI->value, 'web');

        $users = User::get();

        /*if ($users->isNotEmpty()) {*/
        /*    $users->each(function ($user) use ($tenagaPengajar) {*/
        /*        $user->assignRole($tenagaPengajar);*/
        /*    });*/
        /**/
        /*    $users->filter(function ($user) {*/
        /*        return str_contains($user->email, 'kaprodi');*/
        /*    })->each(function ($user) use ($kaprodi) {*/
        /*        $user->assignRole($kaprodi);*/
        /*    });*/
        /**/
        /*    $users->filter(function ($user) {*/
        /*        return str_contains($user->email, 'gkmp');*/
        /*    })->each(function ($user) use ($gkmp) {*/
        /*        $user->assignRole($gkmp);*/
        /*    });*/
        /*}*/

        $me = User::where('email', 'elangpermadani123@gmail.com')->first();
        if ($me) {
            $me->assignRole($tenagaPengajar);
        }

        $userAdmin = User::where('email', 'admin@admin.com')->first();
        if ($userAdmin) {
            $userAdmin->assignRole($admin);
        }

        $superadminUser = User::where('email', 'superadmin@admin.com')->first();
        if ($superadminUser) {
            $superadminUser->assignRole($superadmin);
        }
    }
}
