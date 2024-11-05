<div class="min-h-2 space-y-2">
    <h3 class="text-2xl font-semibold" id="presensi-dan-keaktifan">Presensi dan Keaktifan</h3>
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse whitespace-nowrap border border-zinc-50 pb-8 text-left">
            <thead class="uppercase">
                <tr>
                    <th class="border border-zinc-100 px-2 py-2">Pertemuan (minggu)</th>
                    <th class="border border-zinc-100 px-2 py-2">Peserta Hadir</th>
                    <th class="border border-zinc-100 px-2 py-2">Peserta yang aktif diskusi</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i < 17; $i++)
                    <tr class="align-top odd:bg-zinc-50 even:bg-white">
                        <td class="border border-zinc-100 px-2 py-2">Kriteria Bentuk-{{ $i }}</td>
                        <td class="border border-zinc-100 px-2 py-2">Rata Rata Nilai-{{ $i }}</td>
                        <td class="border border-zinc-100 px-2 py-2">Kriteria Bentuk-{{ $i }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
