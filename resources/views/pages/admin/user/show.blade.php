<x-app-layout>
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.person-icon />
            Detail Pengguna
        </span>
        <div class="flex flex-col md:flex-row">
            <section class="flex-[0.5] rounded-md min-h-[calc(100vh - 20vh)]">
                <div class="h-[200px] w-[200px] rounded-full bg-zinc-200">

                </div>
            </section>
            <section class="flex-1 rounded-md">
                <table class="border-collapse  w-full">
                    @foreach ($user->toArray() as $key => $value)
                        @php
                            switch ($key) {
                                case 'email':
                                    $value = "<a href='mailto:$value' class='text-blue-500 underline'>$value</a>";
                                    break;
                                case 'name':
                                    $key = 'Nama';
                                    break;
                                case 'created_at':
                                    $value = \Carbon\Carbon::parse($value)
                                        ->locale('id')
                                        ->isoFormat('dddd, D MMMM Y HH:mm');
                                    $key = 'Dibuat pada';
                                    break;
                                case 'updated_at':
                                    $value = \Carbon\Carbon::parse($value)
                                        ->locale('id')
                                        ->isoFormat('dddd, D MMMM Y HH:mm');
                                    $key = 'Diperbarui pada';
                                    break;
                                case 'roles':
                                    $value = array_map(function ($role) {
                                        return App\Enums\RolesEnum::from($role['name'])->badge();
                                    }, $value);

                                    $value = implode(' ', $value);
                                    $key = 'Role';
                                    break;
                                case 'lecturer':
                                    $value = is_null($value) ? '-' : $value['nip'];
                                    $key = 'NIP';
                                    break;
                                default:
                                    $value = $value;
                                    break;
                            }

                        @endphp
                        <tr class="w-full">
                            <td class="border border-y-2 border-x-0 border-zinc-100 px-2 py-2 w-36 capitalize">
                                {{ $key }}
                            </td>
                            <td class="border border-y-2 border-x-0 border-zinc-100 px-2 py-2 w-2">
                                :
                            </td>
                            <td class="border border-y-2 border-x-0 border-zinc-100 px-2 py-2">
                                <div class="flex gap-1">
                                    {!! $value !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </section>
        </div>
    </div>

</x-app-layout>
