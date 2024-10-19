<div class="space-y-4 mt-8 min-w-full">
    <!--tahun ajaran -->
    <div>
        <div class="flex justify-center items-center gap-2">
            <x-label htmlFor="tahun-ajaran">Tahun Akademik</x-label>
            <x-select class="w-[180px]" id="tahun-ajaran">
                <option value="Select a fruit" selected disabled>- Pilih -</option>
                <option value="apple">2024/2025 Gasal</option>
            </x-select>
            <x-button class="bg-blue-500 hover:bg-blue-600">Tampilkan</x-button>
        </div>
    </div>

    <!--Enties dan Search-->
    <div class="flex justify-between">
        <div class="flex items-center gap-2">
            <x-label htmlFor="perPage">Show</x-label>
            <x-select class="w-[75px]" id="tahun-ajaran">
                <option value="apple">10</option>
                <option value="apple">20</option>
            </x-select>
            <x-label htmlFor="perPage">Entries</x-label>
        </div>
        <div class="flex items-center gap-2">
            <x-label htmlFor="tahun-ajaran">Search</x-label>
            <x-input />
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50">
            <thead>
                <tr class="">
                    <th scope="col" class="px-2 py-2 border border-zinc-100">#</th>
                    <th scope="col" class="px-2 py-2 border border-zinc-100">Mata Kuliah</th>
                    <th scope="col" class="px-2 py-2 border border-zinc-100">Tenaga Pengajar</th>
                    <th scope="col" class="px-2 py-2 border border-zinc-100">Status</th>
                    <th scope="col" class="px-2 py-2 border border-zinc-100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 4; $i++)
                    <tr class="odd:bg-white even:bg-zinc-50 ">
                        <td class="px-2 py-2 border border-zinc-100">{{ $i + 1 }}</td>
                        <td class="px-2 py-2 border border-zinc-100">{{ fake()->sentence(3) }}</td>
                        <td class="px-2 py-2 border border-zinc-100">{{ fake()->name }}</td>
                        <td class="px-2 py-2 border border-zinc-100">
                            {{ fake()->randomElement(['Diterima', 'Ditolak', 'Menunggu']) }}</td>
                        <td class="px-2 py-2 border border-zinc-100">
                            Lihat
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
