<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class MasterDataService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllMenusButton()
    {
        return Cache::remember('menus', 60 * 60, function () {

            $menus = [
                (object) [
                    'name' => 'Fakultas',
                    'route' => 'super-admin.fakultas.index',
                    'icon' => 'fas fa-university',
                ],

                (object) [
                    'name' => 'Program Studi',
                    'route' => 'super-admin.program-studi.index',
                    'icon' => 'fas fa-graduation-cap',
                ],

                (object) [
                    'name' => 'Mata Kuliah',
                    'route' => 'super-admin.mata-kuliah.index',
                    'icon' => 'fas fa-book',
                ],

                (object) [
                    'name' => 'Tahun Akademik',
                    'route' => 'super-admin.tahun-akademik.index',
                    'icon' => 'fas fa-calendar-alt',
                ],

                (object) [
                    'name' => 'Kelas',
                    'route' => 'super-admin.kelas.index',
                    'icon' => 'fas fa-school',
                ],

                (object) [
                    'name' => 'Laporan',
                    'route' => 'super-admin.laporan.index',
                    'icon' => 'fas fa-file-alt',
                ],

                (object) [
                    'name' => 'User',
                    'route' => 'super-admin.user.index',
                    'icon' => 'fas fa-users',
                ],

                (object) [
                    'name' => 'Mahasiwa',
                    'route' => 'super-admin.student.index',
                    'icon' => 'fas fa-user-graduate',
                ],

            ];

            return $menus;
        });
    }
}
