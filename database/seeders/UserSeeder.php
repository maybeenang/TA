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
            'email' => 'superadmin@email.com',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
        ]);

        User::factory(10)->create();
    }
}
