<?php

namespace Database\Seeders;

use App\Models\ReportStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReportStatus::create(['name' => 'Draft']);
        ReportStatus::create(['name' => 'Dikirim']);
        ReportStatus::create(['name' => 'Terverifikasi']);
        ReportStatus::create(['name' => 'Ditolak']);
    }
}
