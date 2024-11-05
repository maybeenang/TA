<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Http\Controllers\Controller;
use App\Models\Cpmk;
use Illuminate\Http\Request;

class CpmkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cpmk $cpmk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cpmk $cpmk)
    {
        return view('pages.tenaga-pengajar.cpmk.edit', compact('cpmk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cpmk $cpmk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cpmk $cpmk)
    {
        //
    }
}
