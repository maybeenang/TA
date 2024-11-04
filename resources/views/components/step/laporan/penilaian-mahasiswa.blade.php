<div class="min-h-2 space-y-2">
    <h3 class="text-lg font-semibold" id="penilaian-mahasiswa">Penilaian Mahasiswa</h3>

    <div class="mt-4 overflow-x-auto">
        <table class="w-full table-auto border-collapse whitespace-nowrap border border-zinc-50 pb-8 text-left">
            <thead class="uppercase">
                <tr>
                    <th class="border border-zinc-100 px-2 py-2">No</th>
                    <th class="border border-zinc-100 px-2 py-2">Nim</th>
                    <th class="border border-zinc-100 px-2 py-2">Nama</th>
                    <th class="border border-zinc-100 px-2 py-2">Nilai</th>
                    <th class="border border-zinc-100 px-2 py-2">Total Nilai</th>
                    <th class="border border-zinc-100 px-2 py-2">Praktikum</th>
                    <th class="border border-zinc-100 px-2 py-2">RBL</th>
                    <th class="border border-zinc-100 px-2 py-2">Kehadiran</th>
                    <th class="border border-zinc-100 px-2 py-2">Kuis</th>
                    <th class="border border-zinc-100 px-2 py-2">Tugas</th>
                    <th class="border border-zinc-100 px-2 py-2">UTS</th>
                    <th class="border border-zinc-100 px-2 py-2">UAS</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i < 50; $i++)
                    <tr class="align-top odd:bg-zinc-50 even:bg-white">
                        <td class="border border-zinc-100 px-2 py-2">{{ $i }}</td>
                        <td class="border border-zinc-100 px-2 py-2">123456</td>
                        <td class="border border-zinc-100 px-2 py-2">John Doe</td>
                        <td class="border border-zinc-100 px-2 py-2">A</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
