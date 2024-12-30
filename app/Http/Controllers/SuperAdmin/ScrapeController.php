<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\ScraperService;
use Illuminate\Http\Request;

class ScrapeController extends Controller
{

    public function __construct(
        protected ScraperService $scraperService
    ) {}

    public function scrape()
    {

        try {
            $this->scraperService->scrapeAll();
            return redirect()->route('super-admin.master-data.index')
                ->with('success', 'Berhasil melakukan scraping');
        } catch (\Throwable $th) {

            return back()->withInput()->with('error', 'Gagal melakukan scraping ' . $th->getMessage());
        }
    }
}
