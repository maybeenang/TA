<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Signature;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Reverb\Loggers\Log;

class SignatureController extends Controller
{
    public function index()
    {
        $signatures = Auth::user()->signatures;
        return view('pages.signature.index', compact('signatures'));
    }

    public function show(Signature $signature)
    {
        // check if file is exist
        if (!Storage::disk('public')->exists('signatures/' . $signature->path)) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        return response()->file(Storage::disk('public')->path('signatures/' . $signature->path), [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    public function create()
    {
        session()->put('previous_url', url()->previous());
        return view('pages.signature.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        // randon string generator
        $imageName = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

        $request->file('image')->storeAs('signatures', $imageName, 'public');


        // store to database
        $signature = new Signature();

        $signature->name = $request->name ?? $imageName;
        $signature->path = $imageName;
        $signature->user_id = Auth::id();

        $signature->save();

        $redirectUrl = session()->pull('previous_url', route('signature.index')) ?? route('signature.index');

        return redirect()->to($redirectUrl)->with('success', 'Tanda tangan berhasil dibuat');
    }

    public function edit(Signature $signature)
    {
        return view('pages.signature.edit', compact('signature'));
    }

    public function update(Request $request, Signature $signature)
    {
        $request->validate([
            'name' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {

            // randon string generator
            $imageName = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

            // delete old File
            Storage::disk('public')->delete('signatures/' . $signature->path);

            $request->file('image')->storeAs('signatures', $imageName, 'public');

            $signature->path = $imageName;
        } else {
            $imageName = $signature->path;
        }

        $signature->name = $request->name ?? $imageName;

        $signature->save();

        return redirect()->intended(route('signature.index', absolute: false))->with('success', 'Tanda tangan berhasil diubah');
    }

    public function destroy(Signature $signature)
    {

        Storage::disk('public')->delete('signatures/' . $signature->path);

        $signature->delete();

        return redirect()->intended(route('signature.index', absolute: false))->with('success', 'Tanda tangan berhasil dihapus');
    }
}
