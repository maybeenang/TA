<x-app-layout>
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Detail Pengguna
        </span>
        <div class="flex flex-col gap-4 md:flex-row">
            <section
                class="flex min-h-[40vh] flex-[0.5] flex-col items-center justify-center gap-2 rounded-md md:justify-start"
            >
                <div class="mx-auto h-[300px] w-[300px] rounded-md bg-zinc-200 md:h-[200px] md:w-[200px]">
                    <img
                        src="{{ $user->profile_picture_path }}"
                        alt="{{ $user->name }}"
                        class="h-full w-full rounded-md object-cover"
                    />
                </div>
                <a href="{{ route("admin.user.edit", $user) }}">
                    <x-button>Edit Informasi Pengguna</x-button>
                </a>
            </section>

            <section class="flex-1 rounded-md">
                <table class="w-full border-collapse">
                    @foreach ($user->toArray() as $key => $value)
                        @php
                            switch ($key) {
                                case "email":
                                    $value = "<a href='mailto:$value' class='text-blue-500 underline'>$value</a>";
                                    break;
                                case "name":
                                    $key = "Nama";
                                    break;
                                case "created_at":
                                    $value = \Carbon\Carbon::parse($value)
                                        ->locale("id")
                                        ->isoFormat("dddd, D MMMM Y HH:mm");
                                    $key = "Dibuat pada";
                                    break;
                                case "updated_at":
                                    $value = \Carbon\Carbon::parse($value)
                                        ->locale("id")
                                        ->isoFormat("dddd, D MMMM Y HH:mm");
                                    $key = "Diperbarui pada";
                                    break;
                                case "roles":
                                    $value = array_map(function ($role) {
                                        return App\Enums\RolesEnum::from($role["name"])->badge();
                                    }, $value);

                                    $value = implode(" ", $value);
                                    $key = "Role";
                                    break;
                                case "lecturer":
                                    $value = is_null($value) ? "-" : $value["nip"];
                                    $key = "NIP";
                                    break;
                                default:
                                    $value = $value;
                                    break;
                            }
                        @endphp

                        <tr class="w-full">
                            <td class="w-36 border border-x-0 border-y-2 border-zinc-100 px-2 py-2 capitalize">
                                {{ $key }}
                            </td>
                            <td class="w-2 border border-x-0 border-y-2 border-zinc-100 px-2 py-2">:</td>
                            <td class="border border-x-0 border-y-2 border-zinc-100 px-2 py-2">
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
