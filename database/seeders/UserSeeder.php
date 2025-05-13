<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'superadmin' => Role::findOrCreate(RolesEnum::SUPERADMIN->value, 'web'),
            'admin' => Role::findOrCreate(RolesEnum::ADMIN->value, 'web'),
            'tenaga_pengajar' => Role::findOrCreate(RolesEnum::TENAGAPENGAJAR->value, 'web'),
            'kaprodi' => Role::findOrCreate(RolesEnum::KAPRODI->value, 'web'),
            'gkmp' => Role::findOrCreate(RolesEnum::GKMP->value, 'web'),
        ];

        $programStudiIF = ProgramStudi::where('name', 'LIKE', '%Informatika%')->first();

        User::create([
            'name' => 'Super Admin',
            'email' => "superadmin@admin.com",
            'password' => bcrypt('password'),
            'program_studi_id' => $programStudiIF->id,
            'email_verified_at' => now(),
        ])->assignRole($roles['superadmin'])
            ->lecturer()->create([
                'nip' => fake()->unique()->randomNumber(9),
            ]);

        User::create([
            'name' => 'Admin',
            'email' => "admin@admin.com",
            'password' => bcrypt('password'),
            'program_studi_id' => $programStudiIF->id,
            'email_verified_at' => now(),
        ])->assignRole($roles['admin'])
            ->lecturer()->create([
                'nip' => fake()->unique()->randomNumber(9),
            ]);

        $dosen = [
            [
                "nama" => "Andika Setiawan, S.Kom., M.Cs.",
                "email" => "andika.setiawan@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-andika-setiawan/",
                "nip" => "19911127 2022 03 1 007"
            ],
            [
                "nama" => "Eko Dwi Nugroho, S.Kom., M.Cs.",
                "email" => "eko.nugroho@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-eko-dwi-nugroho/",
                "nip" => "19910209 202406 1 001"
            ],
            [
                "nama" => "Muhammad Habib Algifari, S.Kom., M.TI.",
                "email" => "muhammad.algifari@if.itera.ac.id",
                "link" => "https://mhabibalgifari.blog/",
                "nip" => ""
            ],
            [
                "nama" => "Winda Yulita, M.Cs.",
                "email" => "winda.yulita@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/profil-winda-yulita/",
                "nip" => "19930727 2022 03 2 022"
            ],
            [
                "nama" => "Radhinka Bagaskara, S.Si.Kom., M.Si., M.Sc.",
                "email" => "radhinka.bagaskara@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-radhinka-bagaskara/",
                "nip" => "19941127 202012 1 018"
            ],
            [
                "nama" => "Meida Cahyo Untoro, S.Kom., M.Kom",
                "email" => "cahyo.untoro@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-meida-cahyo-untoro/",
                "nip" => "19890518 201903 1 011"
            ],
            [
                "nama" => "Ilham Firman Ashari, S.Kom., M.T",
                "email" => "firman.ashari@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-ilham-firman-ashari/",
                "nip" => "19930314 201903 1 018"
            ],
            [
                "nama" => "Leslie Anggraini, S.Kom., M.Cs.",
                "email" => "leslie.anggraini@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/profil-leslie-anggraini/",
                "nip" => "1997081720242294"
            ],
            [
                "nama" => "Miranti Verdiana, M.Si.",
                "email" => "miranti.verdiana@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/profil-miranti/",
                "nip" => "199209052022032008"
            ],
            [
                "nama" => "Ir. Hira Laksmiwati Soemitro, M.Sc.",
                "email" => "hira@informatika.org",
                "link" => "mailto:hira@informatika.org",
                "nip" => ""
            ],
            [
                "nama" => "Rajif Agung Yunmar, S.Kom., M.Cs.",
                "email" => "rajif@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-rajif-agung-yunmar/",
                "nip" => "19880309 201504 1 002"
            ],
            [
                "nama" => "Raidah Hanifah, S.T., M.T.",
                "email" => "raidah.hanifah@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-raidah-hanifah/",
                "nip" => "19890415 201504 2 006"
            ],
            [
                "nama" => "Arkham Zahri Rakhman S.Kom., M.Eng.",
                "email" => "arkham@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-arkham-zahri-rakhman/",
                "nip" => "19900404 201903 1 020"
            ],
            [
                "nama" => "Rahman Indra Kesuma, S.Kom., M.Cs.",
                "email" => "rahman.indra@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-rahman-indra-kesuma/",
                "nip" => "19910530 201903 1 018"
            ],
            [
                "nama" => "Hafiz Budi Firmansyah S.Kom., M.Sc.",
                "email" => "hafiz.budi@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-hafiz-budi-firmansyah/",
                "nip" => "19910824 201903 1 014"
            ],
            [
                "nama" => "I Wayan Wiprayoga Wisesa S.Kom., M.Kom",
                "email" => "wayan.wisesa@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-i-wayan-wiprayoga-wisesa/",
                "nip" => "19890322 201903 1 009"
            ],
            [
                "nama" => "Imam Ekowicaksono, S.Si., M.Si.",
                "email" => "imam.wicaksono@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-imam-eko-wicaksono/",
                "nip" => "19890517 201903 1 013"
            ],
            [
                "nama" => "Hartanto Tantriawan, S.Kom., M.Kom.",
                "email" => "hartanto.tantriawan@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-hartanto-tantriawan/",
                "nip" => "19920522 201903 1 012"
            ],
            [
                "nama" => "Angga Wijaya S.Si., M.Si.",
                "email" => "angga.wijaya@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-angga-wijaya/",
                "nip" => "1992 05082018 1 098"
            ],
            [
                "nama" => "Amirul Iqbal S.Kom., M.Eng.",
                "email" => "amirul.iqbal@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-amirul-iqbal/",
                "nip" => "19910802 201903 1 013"
            ],
            [
                "nama" => "Mohamad Idris S.Si., M.Sc.",
                "email" => "mohamad.idris@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-mohamad-idris/",
                "nip" => "19861010 201903 1 016"
            ],
            [
                "nama" => "Arief Ichwani S.Kom., M.Cs.",
                "email" => "arief.ichwani@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-arief-ichwani/",
                "nip" => "19900811 201903 1 011"
            ],
            [
                "nama" => "Martin C.T. Manullang, Ph.D.",
                "email" => "martin.manullang@if.itera.ac.id",
                "link" => "https://mctm.web.id/resume/",
                "nip" => ""
            ],
            [
                "nama" => "Ir. Mugi Praseptiawan S.T., M.Kom",
                "email" => "mugi.praseptiawan@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-mugi-praseptiawan/",
                "nip" => "19850921 201903 1 012"
            ],
            [
                "nama" => "Andre Febrianto S.Kom., M.Eng",
                "email" => "andre.febrianto@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-andre-febrianto/",
                "nip" => "198602142019031008"
            ],
            [
                "nama" => "Aidil Afriansyah, S.Kom., M.Kom.",
                "email" => "aidil.afriansyah@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/dosen-aidil-afriansyah/",
                "nip" => "19910416 201903 1 015"
            ],
            [
                "nama" => "Prof. Sarwono Sutikno, Dr,Eng., CISA, CISSP, CISM, CSX-F, IIAP, CC",
                "email" => "sarwono.sutikno@if.itera.ac.id",
                "link" => "http://s.id/WonSS",
                "nip" => ""
            ],
            [
                "nama" => "Siswanto, S.Pd., M.Si.",
                "email" => "siswanto@if.itera.ac.id",
                "link" => "http://if.itera.ac.id/profil-siswanto/",
                "nip" => "198207032024211010"
            ],
            [
                "nama" => "Ade Setiawan, S.Si.",
                "email" => "ade.setiawan@staff.itera.ac.id",
                "link" => "",
                "nip" => ""
            ],
            [
                "nama" => "M. Fitrah Ramadhan, S.Kom.",
                "email" => "fitrah.ramadhan@staff.itera.ac.id",
                "link" => "",
                "nip" => ""
            ],
            [
                "nama" => "Dirga Rama Sudira, S.T.",
                "email" => "dirga.sudira@staff.itera.ac.id",
                "link" => "",
                "nip" => ""
            ]
        ];


        foreach ($dosen as $value) {
            $user = User::create([
                'name' => $value['nama'],
                'email' => $value['email'],
                'password' => bcrypt('password'),
                'program_studi_id' => $programStudiIF->id,
                'email_verified_at' => now(),
            ]);

            $user->assignRole($roles['tenaga_pengajar']);

            $user->lecturer()->create([
                'nip' => preg_replace('/\s+/', '', $value['nip']) ?: fake()->unique()->randomNumber(9),
            ]);
        }
    }
}
