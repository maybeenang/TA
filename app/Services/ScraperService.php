<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ScraperService
{
    public function scrapeAll()
    {
        try {
            $response = Http::timeout(-1)->get('http://localhost:3000/fakultas-prodi');
            $data = $response->json('data');
            dd($data);
            return $data;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
