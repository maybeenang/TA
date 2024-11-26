<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 4 academic years, starting from now to 4 years later
        AcademicYear::create([
            'name' => '2024/2025',
            'semester' => 'Ganjil',
            'start_date' => '2024-09-01',
            'end_date' => '2024-12-31',
        ]);
        AcademicYear::create([
            'name' => '2024/2025',
            'semester' => 'Genap',
            'start_date' => '2025-01-01',
            'end_date' => '2025-05-31',
        ]);
        AcademicYear::create([
            'name' => '2024/2025',
            'semester' => 'Pendek',
            'start_date' => '2025-06-01',
            'end_date' => '2025-08-31',
        ]);
    }
}
