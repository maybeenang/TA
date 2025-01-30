<?php

namespace App\Imports;

use App\Enums\RolesEnum;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;

class UsersImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {
            if (empty($row['nama']) || empty($row['email']) || empty($row['nip'])) {
                return null;
            }
            DB::beginTransaction();
            User::firstOrNew([
                'email' => $row['email']
            ], [
                'name' => $row['nama'],
                'password' => bcrypt('password'),
                'program_studi_id' => auth()->user()->program_studi_id
            ])->save();

            $user = User::where('email', $row['email'])->first();
            Lecturer::firstOrNew([
                'nip' => $row['nip']
            ], [
                'user_id' => $user->id
            ])->save();

            $tenagaPengajar = app(Role::class)->findOrCreate(RolesEnum::TENAGAPENGAJAR->value, 'web');
            $user->assignRole($tenagaPengajar);

            DB::commit();
        } catch (\Throwable $th) {

            DB::rollBack();

            return null;
        }

        return $user;
    }
}
