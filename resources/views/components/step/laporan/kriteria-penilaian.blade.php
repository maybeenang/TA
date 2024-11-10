<div class="min-h-2 space-y-2">
    <h3 class="text-2xl font-semibold" id="kriteria-penilaian">Kriteria Penilaian</h3>

    <div class="flex justify-end">
        <x-button.index @click="$dispatch('open-create-grade-component')">Tambah Komponen Penilaian</x-button.index>
    </div>

    <div class="flex justify-between">
        <div class="max-w-fit">
            <livewire:table.tenaga-pengajar.grade-component-table :laporan="$laporan" />
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse whitespace-nowrap border border-zinc-50 pb-8 text-left">
                <thead class="uppercase">
                    <tr>
                        <th class="border border-zinc-100 px-2 py-2">Konversi Nilai</th>
                        <th class="border border-zinc-100 px-2 py-2">Rentang Nilai</th>
                        <th class="border border-zinc-100 px-2 py-2">Kualifikasi Angka Mutu</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 7; $i++)
                        <tr class="align-top odd:bg-zinc-50 even:bg-white">
                            <td class="border border-zinc-100 px-2 py-2">A</td>
                            <td class="border border-zinc-100 px-2 py-2">NA => 75</td>
                            <td class="border border-zinc-100 px-2 py-2">4</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
