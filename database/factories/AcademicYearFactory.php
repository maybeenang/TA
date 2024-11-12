<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicYear>
 */
class AcademicYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // create academic year from now to next year
        return [
            'name' => $this->faker->sentence(2),
            'semester' => $this->faker->randomElement(['Spring', 'Summer', 'Fall', 'Winter']),
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
        ];
    }
}
