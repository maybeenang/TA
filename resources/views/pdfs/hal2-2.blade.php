<div class="space-y-4 text-xs">
    <section class="space-y-2">
        <h2 class="text-sm">6. Pencapaian Mata Kuliah</h2>

        <table class="w-full table-auto border-collapse border">
            <thead>
                <tr>
                    <th class="border border-black font-normal">Capaian Pembelajaran Mata Kuliah</th>
                    <th class="border border-black font-normal">Kriteria dan Bentuk</th>
                    <th class="border border-black font-normal">Rata Rata Nilai Mahasiswa</th>
                    <th class="border border-black font-normal">Konversi Angka Mutu</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($laporan->cpmks as $cpmk)
                    <tr>
                        <td class="border border-black text-left align-top">{{ $cpmk->description }}</td>
                        <td class="border border-black align-top">{{ $cpmk->criteria }}</td>
                        <td class="border border-black align-top">{{ $cpmk->average_score + 0 }}</td>
                        <td class="border border-black align-top">{{ $cpmk->criteria }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>
