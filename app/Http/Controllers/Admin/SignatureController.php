<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Signature;
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

        return view('pages.admin.signature.index', compact('signatures'));
    }

    public function show(Signature $signature)
    {
        // check if file is exist
        if (!Storage::exists('signatures/' . $signature->path)) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        return response()->file(Storage::path('signatures/' . $signature->path));
    }

    public function create()
    {
        session()->put('previous_url', url()->previous());
        return view('pages.admin.signature.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        // randon string generator
        $imageName = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

        // check if dir signatures is not exist
        if (!Storage::exists('signatures')) {
            Storage::makeDirectory('signatures');
        }

        $request->file('image')->storeAs('signatures', $imageName);


        // store to database
        $signature = new Signature();

        $signature->name = $request->name ?? $imageName;
        $signature->path = $imageName;
        $signature->user_id = Auth::id();

        $signature->save();

        // Redirect ke URL yang disimpan atau fallback ke halaman index
        $redirectUrl = session()->pull('previous_url', route('admin.signature.index')) ?? route('admin.signature.index');

        return redirect()->to($redirectUrl)->with('success', 'Tanda tangan berhasil dibuat');
    }

    public function edit(Signature $signature)
    {
        return view('pages.admin.signature.edit', compact('signature'));
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

            // check if dir signatures is not exist
            if (!Storage::exists('signatures')) {
                Storage::makeDirectory('signatures');
            }

            // delete old file
            Storage::delete('signatures/' . $signature->path);

            $request->file('image')->storeAs('signatures', $imageName);

            // delete old file
            Storage::delete('signatures/' . $signature->path);

            $signature->path = $imageName;
        }

        $signature->name = $request->name ?? $imageName;

        $signature->save();

        return redirect()->intended(route('admin.signature.index', absolute: false))->with('success', 'Tanda tangan berhasil diubah');
    }

    public function destroy(Signature $signature)
    {
        // check if file is exist
        if (!Storage::exists('signatures/' . $signature->path)) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        Storage::delete('signatures/' . $signature->path);

        $signature->delete();

        return redirect()->intended(route('admin.signature.index', absolute: false))->with('success', 'Tanda tangan berhasil dihapus');
    }
}
