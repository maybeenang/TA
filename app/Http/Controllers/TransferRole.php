<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class TransferRole extends Controller
{

    public function index()
    {
        // check apakah user memeiliki role gkmp atau kaprodi
        $currentRoles = auth()->user()->getRoleNames();

        // hapus tenaga pengajar dan admin dari current roles
        $currentRoles = $currentRoles->filter(function ($role) {
            return $role !== RolesEnum::TENAGAPENGAJAR->value && $role !== RolesEnum::ADMIN->value;
        });


        // ambil semua user selain user yang sedang login
        $users = User::query()
            ->select('id', 'name')
            ->where('id', '!=', auth()->id())
            ->get();

        return view('pages.transfer-role.index', compact('currentRoles', 'users'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'transferTo' => 'required|exists:users,id',
            'currentRole' => 'required|exists:roles,name'
        ]);

        if ($validated['currentRole'] === RolesEnum::TENAGAPENGAJAR->value || $validated['currentRole'] === RolesEnum::ADMIN->value) {
            return redirect()->route('transfer-role.index')->with('error', 'Role tidak valid');
        }

        try {
            DB::transaction(function () use ($validated) {
                // cari user id yang akan di transfer role
                $user = User::find($validated['transferTo']);

                // cari role yang akan di transfer
                $role = Role::findByName($validated['currentRole']);

                // check apakah user yang akan di transfer role memiliki role yang sama dengan role yang akan di transfer
                if ($user->hasRole($validated['currentRole'])) {
                    throw new \Exception('User sudah memiliki role yang sama');
                }

                // tambahkan role yang baru
                $user->assignRole($role);

                // hapus role yang lama dari user yang sedang login
                auth()->user()->removeRole($validated['currentRole']);
            });

            return redirect()->route('welcome')->with('success', 'Role berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('transfer-role.index')->with('error', 'Role gagal diubah ' . $th->getMessage());
        }
    }
}
