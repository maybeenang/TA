<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            {{ $mataKuliah->name }}
        </span>

        <section>
            <h1 class="text-center text-xl">{{ $mataKuliah->name }}</h1>
        </section>

        <section class="mb-8">
            <table class="w-full border-collapse">
                @foreach ($mataKuliah->toArray() as $key => $value)
                    @php
                        match ($key) {
                            'name' => ($key = 'Nama'),
                            'code' => ($key = 'Kode'),
                            'credit' => ($key = 'SKS'),
                            default => ($key = $key),
                        };
                    @endphp

                    <tr class="w-full">
                        <td class="w-44 border border-x-0 border-y-2 border-zinc-200 px-2 py-2 capitalize">
                            {{ $key }}
                        </td>
                        <td class="w-2 border border-x-0 border-y-2 border-zinc-200 px-2 py-2">:</td>
                        <td class="border border-x-0 border-y-2 border-zinc-200 px-2 py-2">
                            <div class="flex gap-1">
                                {{ $value }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </section>

        <section>
            <livewire:table.kelas-mata-kuliah-table :course="$mataKuliah" />
        </section>
    </div>
</x-app-layout>
