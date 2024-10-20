<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class LecturerSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::get();

        /*chec if user is not empty*/
        if ($users->isNotEmpty()) {
            $users->each(function ($user) {
                $user->lecturer()->create([
                    'nip' => fake()->unique()->randomNumber(9),
                ]);
            });
        }
    }
}
