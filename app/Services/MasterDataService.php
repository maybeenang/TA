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
                    'name' => 'Program Studi',
                    'icon' => 'fas fa-graduation-cap',
                ],

                (object) [
                    'name' => 'Mata Kuliah',
                    'icon' => 'fas fa-book',
                ],

                (object) [
                    'name' => 'Tahun Akademik',
                    'route' => 'super-admin.tahun-akademik.index',
                    'icon' => 'fas fa-calendar-alt',
                ],

                (object) [
                    'name' => 'Kelas',
                    'icon' => 'fas fa-school',
                ],

                (object) [
                    'name' => 'Laporan',
                    'icon' => 'fas fa-file-alt',
                ],

                (object) [
                    'name' => 'User',
                    'icon' => 'fas fa-users',
                ],

                (object) [
                    'name' => 'Mahasiwa',
                    'icon' => 'fas fa-user-graduate',
                ],

            ];

            return $menus;
        });
    }
}
