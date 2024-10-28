<?php

namespace Database\Seeders;

use App\Enums\ReportStatusEnum;
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
        ReportStatus::create(['name' => ReportStatusEnum::DRAFT->value]);
        ReportStatus::create(['name' => ReportStatusEnum::DIKIRIM->value]);
        ReportStatus::create(['name' => ReportStatusEnum::TERVERIFIKASI->value]);
        ReportStatus::create(['name' => ReportStatusEnum::DITOLAK->value]);
    }
}
