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

        /* $me = User::where('email', 'elangpermadani123@gmail.com')->first(); */
        /* if ($me) { */
        /*     $me->assignRole($tenagaPengajar); */
        /* } */
        /**/
        /* $userAdmin = User::where('email', 'admin@admin.com')->first(); */
        /* if ($userAdmin) { */
        /*     $userAdmin->assignRole($admin); */
        /* } */
        /**/
        /* $superadminUser = User::where('email', 'superadmin@admin.com')->first(); */
        /* if ($superadminUser) { */
        /*     $superadminUser->assignRole($superadmin); */
        /* } */
        /**/
        /* $kaprodiUser = User::where('email', 'kaprodi@email.com')->first(); */
        /* if ($kaprodiUser) { */
        /*     $kaprodiUser->assignRole($kaprodi); */
        /* } */
        /**/
        /* $gkmpUser = User::where('email', 'gkmp@email.com')->first(); */
        /* if ($gkmpUser) { */
        /*     $gkmpUser->assignRole($gkmp); */
        /* } */
    }
}
