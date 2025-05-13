<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $fakultas = [
            [
                "fakultas" => "Fakultas SAINS",
                "prodi" => [
                    "Program Studi Fisika (FI)",
                    "Program Studi Matematika",
                    "Program Studi Biologi",
                    "Program Studi Kimia",
                    "Program Studi Farmasi",
                    "Atmosfer dan Keplanetan",
                    "Program Studi Sains Aktuaria",
                    "Progam Studi Sains Lingkungan Kelautan",
                    "Program Studi Sains Data",
                    "Program Studi Magister Fisika"
                ]
            ],
            [
                "fakultas" => "Fakultas Teknologi Infrastruktur dan Kewilayahan",
                "prodi" => [
                    "Program Studi Teknik Geomatika (GT)",
                    "Program Studi Perencanaan Wilayah dan Kota (PWK)",
                    "Program Studi Teknik Sipil (SI)",
                    "Program Studi Arsitektur (AR)",
                    "Program Studi Teknik Lingkungan",
                    "Program Studi Teknik Kelautan",
                    "Program Studi Desain Komunikasi Visual",
                    "Program Studi Arsitektur Lanskap",
                    "Program Studi Teknik Perkeretaapian",
                    "Program Studi Rekayasa Tata Kelola Air Terpardu",
                    "Program Studi Program Studi Pariwisata"
                ]
            ],
            [
                "fakultas" => "Fakultas Teknologi Industri",
                "prodi" => [
                    "Program Studi Teknik Elektro (EL)",
                    "Program Studi Teknik Geofisika (TG)",
                    "Program Studi Teknik Informatika (IF)",
                    "Program Studi Teknik Geologi",
                    "Program Studi Teknik Mesin",
                    "Program Studi Teknik Industri",
                    "Program Studi Teknik Kimia",
                    "Program Studi Teknik Fisika",
                    "Program Studi Teknik Biosistem",
                    "Program Studi Teknologi Industri Pertanian",
                    "Program Studi Teknologi Pangan",
                    "Program Studi Teknik Sistem Energi",
                    "Program Studi Teknik Pertambangan",
                    "Program Studi Teknik Material",
                    "Program Studi Teknik Telekomunikasi",
                    "Rekayasa Kehutanan",
                    "Program Studi Teknik Biomedik",
                    "Program Studi Teknik Rekayasa Keolahragaan",
                    "Program Studi Rekayasa Minyak Dan Gas",
                    "Program Studi Rekayasa Instrumentasi dan Automasi",
                    "Program Studi Rekayasa Kosmetik"
                ]
            ]
        ];

        foreach ($fakultas as $fak) {
            $fakultas = \App\Models\Fakultas::create([
                'name' => $fak['fakultas']
            ]);

            foreach ($fak['prodi'] as $prodi) {
                \App\Models\ProgramStudi::create([
                    'name' => $prodi,
                    'fakultas_id' => $fakultas->id
                ]);
            }
        }
    }
}
