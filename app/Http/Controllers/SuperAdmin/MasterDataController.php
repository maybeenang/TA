<?php

namespace App\Http\Controllers\SUperAdmin;

use App\Http\Controllers\Controller;
use App\Services\MasterDataService;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    protected MasterDataService $masterDataService;

    public function __construct(MasterDataService $masterDataService)
    {
        $this->masterDataService = $masterDataService;
    }

    public function index()
    {
        $menus = $this->masterDataService->getAllMenusButton();

        return view('pages.super-admin.master-data.index', compact('menus'));
    }
}
