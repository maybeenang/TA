<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct(protected UserService $userService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('pages.super-admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $roles = RolesEnum::toSelectArray();
        $programStudis = ProgramStudi::pluck('name', 'id');

        return view('pages.super-admin.user.create', compact('roles', 'programStudis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|unique:lecturers,nip|regex:/^[0-9 ]+$/',
            'roles.*' => 'exists:roles,name',
            'programStudi' => 'required|exists:program_studis,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $this->userService->create($validated);

            return redirect()->route('super-admin.user.index')->with('success', 'Berhasil menambahkan pengguna');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Gagal menambahkan pengguna ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = RolesEnum::toSelectArray();
        $programStudis = ProgramStudi::pluck('name', 'id');

        return view('pages.super-admin.user.edit', compact('user', 'roles', 'programStudis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'required|unique:lecturers,nip,' . $user->lecturer->id . '|regex:/^[0-9 ]+$/',
            'roles.*' => 'exists:roles,name',
            'programStudi' => 'required|exists:program_studis,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $this->userService->update($user, $validated);

            return redirect()->route('super-admin.user.index')->with('success', 'Berhasil mengubah pengguna');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Gagal mengubah pengguna ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->isSuperAdmin) {
            return back()->with('error', 'Tidak dapat menghapus super admin');
        }

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus diri sendiri');
        }

        try {
            $user->delete();

            return redirect()->route('super-admin.user.index')->with('success', 'Berhasil menghapus pengguna');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menghapus pengguna ' . $th->getMessage());
        }
    }
}
