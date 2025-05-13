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

        $academicYears = [
            [
                "id" => "20251",
                "name" => "2025/2026",
                "semester" => "Ganjil",
                "fullName" => "2025/2026 Ganjil",
                "tahunAwal" => "2025",
                "tahunAkhir" => "2026"
            ],
            [
                "id" => "20243",
                "name" => "2024/2025",
                "semester" => "Pendek",
                "fullName" => "2024/2025 Pendek",
                "tahunAwal" => "2024",
                "tahunAkhir" => "2025"
            ],
            [
                "id" => "20242",
                "name" => "2024/2025",
                "semester" => "Genap",
                "fullName" => "2024/2025 Genap",
                "tahunAwal" => "2024",
                "tahunAkhir" => "2025"
            ],
            [
                "id" => "20241",
                "name" => "2024/2025",
                "semester" => "Ganjil",
                "fullName" => "2024/2025 Ganjil",
                "tahunAwal" => "2024",
                "tahunAkhir" => "2025"
            ],
            [
                "id" => "20233",
                "name" => "2023/2024",
                "semester" => "Pendek",
                "fullName" => "2023/2024 Pendek",
                "tahunAwal" => "2023",
                "tahunAkhir" => "2024"
            ],
            [
                "id" => "20232",
                "name" => "2023/2024",
                "semester" => "Genap",
                "fullName" => "2023/2024 Genap",
                "tahunAwal" => "2023",
                "tahunAkhir" => "2024"
            ],
            [
                "id" => "20231",
                "name" => "2023/2024",
                "semester" => "Ganjil",
                "fullName" => "2023/2024 Ganjil",
                "tahunAwal" => "2023",
                "tahunAkhir" => "2024"
            ],
            [
                "id" => "20223",
                "name" => "2022/2023",
                "semester" => "Pendek",
                "fullName" => "2022/2023 Pendek",
                "tahunAwal" => "2022",
                "tahunAkhir" => "2023"
            ],
            [
                "id" => "20222",
                "name" => "2022/2023",
                "semester" => "Genap",
                "fullName" => "2022/2023 Genap",
                "tahunAwal" => "2022",
                "tahunAkhir" => "2023"
            ],
            [
                "id" => "20221",
                "name" => "2022/2023",
                "semester" => "Ganjil",
                "fullName" => "2022/2023 Ganjil",
                "tahunAwal" => "2022",
                "tahunAkhir" => "2023"
            ],
            [
                "id" => "20213",
                "name" => "2021/2022",
                "semester" => "Pendek",
                "fullName" => "2021/2022 Pendek",
                "tahunAwal" => "2021",
                "tahunAkhir" => "2022"
            ],
            [
                "id" => "20212",
                "name" => "2021/2022",
                "semester" => "Genap",
                "fullName" => "2021/2022 Genap",
                "tahunAwal" => "2021",
                "tahunAkhir" => "2022"
            ],
            [
                "id" => "20211",
                "name" => "2021/2022",
                "semester" => "Ganjil",
                "fullName" => "2021/2022 Ganjil",
                "tahunAwal" => "2021",
                "tahunAkhir" => "2022"
            ],
            [
                "id" => "20203",
                "name" => "2020/2021",
                "semester" => "Pendek",
                "fullName" => "2020/2021 Pendek",
                "tahunAwal" => "2020",
                "tahunAkhir" => "2021"
            ],
            [
                "id" => "20202",
                "name" => "2020/2021",
                "semester" => "Genap",
                "fullName" => "2020/2021 Genap",
                "tahunAwal" => "2020",
                "tahunAkhir" => "2021"
            ],
            [
                "id" => "20201",
                "name" => "2020/2021",
                "semester" => "Ganjil",
                "fullName" => "2020/2021 Ganjil",
                "tahunAwal" => "2020",
                "tahunAkhir" => "2021"
            ],
            [
                "id" => "20193",
                "name" => "2019/2020",
                "semester" => "Pendek",
                "fullName" => "2019/2020 Pendek",
                "tahunAwal" => "2019",
                "tahunAkhir" => "2020"
            ],
            [
                "id" => "20192",
                "name" => "2019/2020",
                "semester" => "Genap",
                "fullName" => "2019/2020 Genap",
                "tahunAwal" => "2019",
                "tahunAkhir" => "2020"
            ],
            [
                "id" => "20191",
                "name" => "2019/2020",
                "semester" => "Ganjil",
                "fullName" => "2019/2020 Ganjil",
                "tahunAwal" => "2019",
                "tahunAkhir" => "2020"
            ],
            [
                "id" => "20183",
                "name" => "2018/2019",
                "semester" => "Pendek",
                "fullName" => "2018/2019 Pendek",
                "tahunAwal" => "2018",
                "tahunAkhir" => "2019"
            ],
            [
                "id" => "20182",
                "name" => "2018/2019",
                "semester" => "Genap",
                "fullName" => "2018/2019 Genap",
                "tahunAwal" => "2018",
                "tahunAkhir" => "2019"
            ],
            [
                "id" => "20181",
                "name" => "2018/2019",
                "semester" => "Ganjil",
                "fullName" => "2018/2019 Ganjil",
                "tahunAwal" => "2018",
                "tahunAkhir" => "2019"
            ],
            [
                "id" => "20173",
                "name" => "2017/2018",
                "semester" => "Pendek",
                "fullName" => "2017/2018 Pendek",
                "tahunAwal" => "2017",
                "tahunAkhir" => "2018"
            ],
            [
                "id" => "20172",
                "name" => "2017/2018",
                "semester" => "Genap",
                "fullName" => "2017/2018 Genap",
                "tahunAwal" => "2017",
                "tahunAkhir" => "2018"
            ],
            [
                "id" => "20171",
                "name" => "2017/2018",
                "semester" => "Ganjil",
                "fullName" => "2017/2018 Ganjil",
                "tahunAwal" => "2017",
                "tahunAkhir" => "2018"
            ],
            [
                "id" => "20163",
                "name" => "2016/2017",
                "semester" => "Pendek",
                "fullName" => "2016/2017 Pendek",
                "tahunAwal" => "2016",
                "tahunAkhir" => "2017"
            ],
            [
                "id" => "20162",
                "name" => "2016/2017",
                "semester" => "Genap",
                "fullName" => "2016/2017 Genap",
                "tahunAwal" => "2016",
                "tahunAkhir" => "2017"
            ],
            [
                "id" => "20161",
                "name" => "2016/2017",
                "semester" => "Ganjil",
                "fullName" => "2016/2017 Ganjil",
                "tahunAwal" => "2016",
                "tahunAkhir" => "2017"
            ],
            [
                "id" => "20153",
                "name" => "2015/2016",
                "semester" => "Pendek",
                "fullName" => "2015/2016 Pendek",
                "tahunAwal" => "2015",
                "tahunAkhir" => "2016"
            ],
            [
                "id" => "20152",
                "name" => "2015/2016",
                "semester" => "Genap",
                "fullName" => "2015/2016 Genap",
                "tahunAwal" => "2015",
                "tahunAkhir" => "2016"
            ],
            [
                "id" => "20151",
                "name" => "2015/2016",
                "semester" => "Ganjil",
                "fullName" => "2015/2016 Ganjil",
                "tahunAwal" => "2015",
                "tahunAkhir" => "2016"
            ],
            [
                "id" => "20143",
                "name" => "2014/2015",
                "semester" => "Pendek",
                "fullName" => "2014/2015 Pendek",
                "tahunAwal" => "2014",
                "tahunAkhir" => "2015"
            ],
            [
                "id" => "20142",
                "name" => "2014/2015",
                "semester" => "Genap",
                "fullName" => "2014/2015 Genap",
                "tahunAwal" => "2014",
                "tahunAkhir" => "2015"
            ],
            [
                "id" => "20141",
                "name" => "2014/2015",
                "semester" => "Ganjil",
                "fullName" => "2014/2015 Ganjil",
                "tahunAwal" => "2014",
                "tahunAkhir" => "2015"
            ],
            [
                "id" => "20133",
                "name" => "2013/2014",
                "semester" => "Pendek",
                "fullName" => "2013/2014 Pendek",
                "tahunAwal" => "2013",
                "tahunAkhir" => "2014"
            ],
            [
                "id" => "20132",
                "name" => "2013/2014",
                "semester" => "Genap",
                "fullName" => "2013/2014 Genap",
                "tahunAwal" => "2013",
                "tahunAkhir" => "2014"
            ],
            [
                "id" => "20131",
                "name" => "2013/2014",
                "semester" => "Ganjil",
                "fullName" => "2013/2014 Ganjil",
                "tahunAwal" => "2013",
                "tahunAkhir" => "2014"
            ],
            [
                "id" => "20123",
                "name" => "2012/2013",
                "semester" => "Pendek",
                "fullName" => "2012/2013 Pendek",
                "tahunAwal" => "2012",
                "tahunAkhir" => "2013"
            ],
            [
                "id" => "20122",
                "name" => "2012/2013",
                "semester" => "Genap",
                "fullName" => "2012/2013 Genap",
                "tahunAwal" => "2012",
                "tahunAkhir" => "2013"
            ],
            [
                "id" => "20121",
                "name" => "2012/2013",
                "semester" => "Ganjil",
                "fullName" => "2012/2013 Ganjil",
                "tahunAwal" => "2012",
                "tahunAkhir" => "2013"
            ]
        ];

        foreach ($academicYears as $value) {
            $startDate = null;
            $endDate = null;

            switch ($value['semester']) {
                case 'Ganjil':
                    $startDate = date('Y-m-d', strtotime($value['tahunAwal'] . '-09-01'));
                    $endDate = date('Y-m-d', strtotime($value['tahunAwal'] . '-12-31'));
                    break;
                case 'Genap':
                    $startDate = date('Y-m-d', strtotime($value['tahunAkhir'] . '-01-01'));
                    $endDate = date('Y-m-d', strtotime($value['tahunAkhir'] . '-05-31'));
                    break;
                case 'Pendek':
                    $startDate = date('Y-m-d', strtotime($value['tahunAkhir'] . '-06-01'));
                    $endDate = date('Y-m-d', strtotime($value['tahunAkhir'] . '-08-31'));
                    break;
            }

            AcademicYear::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'semester' => $value['semester'],
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }
    }
}
