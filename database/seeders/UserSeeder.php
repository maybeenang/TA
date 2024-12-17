<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        User::factory()->create([
            'name' => 'Elang Permadani',
            'email' => 'elangpermadani123@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Kaprodi',
            'email' => 'kaprodi@email.com'
        ]);

        User::factory()->create([
            'name' => 'GKMP',
            'email' => 'gkmp@email.com'
        ]);


        User::factory(20)->create();
    }
}
