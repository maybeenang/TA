<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $roles = RolesEnum::toSelectArray();
        unset($roles[RolesEnum::SUPERADMIN->value]);

        return view('pages.admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // check if tenaga_pengajar is checked

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|unique:lecturers,nip|digits_between:10,20',
            'roles.*' => 'required|exists:roles,name',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $user = User::create([
                    'email' => $validated['email'],
                    'name' => $validated['name'],
                    'password' => bcrypt($validated['password']),
                    'program_studi_id' => Auth::user()->program_studi_id ?? null,
                ]);

                $user->lecturer()->create([
                    'nip' => $validated['nip'],
                ]);

                $roles = Role::whereIn('name', $validated['roles'])->get();

                $user->syncRoles($roles);
            });
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan user ' . $th->getMessage());
        }

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = $user->load(['roles', 'lecturer']);
        // hide crucial information
        $user->makeHidden(['email_verified_at', 'password', 'remember_token', 'id', 'deleted_at', 'profile_picture_path']);
        return view('pages.admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = RolesEnum::toSelectArray();
        unset($roles[RolesEnum::SUPERADMIN->value]);

        return view('pages.admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::findOrFail($id);

        $hasRoles = $request->has('roles');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'nip' => 'nullable|unique:lecturers,nip' . ($user->lecturer ? ',' . $user->lecturer->id : '') . '|digits_between:10,20',
            'roles.*' => 'exists:roles,name',
        ]);

        try {
            DB::transaction(function () use ($validated, $user, $hasRoles) {
                $user->update([
                    'email' => $validated['email'],
                    'name' => $validated['name'],
                    // check if password is not null
                    'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
                ]);

                // check if nip input is not null
                if ($validated['nip']) {
                    if ($user->lecturer) {
                        $user->lecturer->update([
                            'nip' => $validated['nip'],
                        ]);
                    } else {
                        $user->lecturer()->create([
                            'nip' => $validated['nip'],
                        ]);
                    }
                }


                if ($hasRoles) {
                    $roles = Role::whereIn('name', $validated['roles'])->get();
                    $user->syncRoles($roles);
                }
            });
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate user ' . $th->getMessage());
        }

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        try {
            DB::transaction(function () use ($user) {
                $user->delete();
            });
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus user ' . $th->getMessage());
        }

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
