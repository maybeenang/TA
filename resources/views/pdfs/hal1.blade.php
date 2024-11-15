<h1 class="text-center text-xl font-bold">PORTOFOLIO PERKULIAHAN</h1>
<div class="mt-8 w-full">
    <table class="w-fit whitespace-nowrap text-xs">
        <tr>
            <td class="w-[200px]">Mata Kuliah (Kode MK/SKS)</td>
            <td class="w-4">:</td>
            <td>
                {{ $laporan->classroom->name ?? "-" }} / {{ $laporan->classroom->course->name ?? "-" }}
                ({{ $laporan->classroom->course->code ?? "-" }} / {{ $laporan->classroom->course->credit ?? "-" }})
            </td>
        </tr>
        <tr>
            <td class="w-[200px]">Dosen Penanggung Jawab</td>
            <td class="w-4">:</td>
            <td>{{ $laporan->responsibleLecturer?->user?->name ?? "-" }}</td>
        </tr>
        @foreach ($laporan->lecturers as $lecturer)
            <tr>
                <td>
                    @if ($loop->first)
                        Dosen Pengampu
                    @endif
                </td>
                <td>:</td>
                <td>{{ $lecturer->user->name ?? "-" }}</td>
            </tr>
        @endforeach

        <tr>
            <td>Semester (Ganjil / Genap)</td>
            <td>:</td>
            <td>{{ $laporan->classroom->academicYear->semester }}</td>
        </tr>
        <tr>
            <td>Tahun ajaran</td>
            <td>:</td>
            <td>{{ $laporan->classroom->academicYear->name }}</td>
        </tr>

        <tr>
            <td>Jumlah Mahasiswa</td>
            <td>:</td>
            <td>{{ $laporan->classroom->students->count() }}</td>
        </tr>
    </table>
</div>

<div class="mt-8 space-y-4 text-xs">
    <section class="space-y-2">
        <h2 class="text-sm">1. Metode Perkuliahan</h2>
        <p>
            {{ $laporan?->teaching_methods ?? "-" }}
        </p>
    </section>

    <section class="space-y-2">
        <h2 class="text-sm">2. Metode Evaluasi</h2>
        <table class="w-full table-auto border-collapse border">
            <thead>
                <tr>
                    <th class="w-24 border border-black font-normal">Kode CPMK</th>
                    <th class="border border-black font-normal">Deskripsi</th>
                    <th class="w-32 border border-black font-normal">Metode</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan->cpmks as $cpmk)
                    <tr>
                        <td class="border border-black align-top">{{ $cpmk->code }}</td>
                        <td class="border border-black align-top">{{ $cpmk->description }}</td>
                        <td class="border border-black align-top">{{ $cpmk->criteria }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="border border-black">-</td>
                        <td class="border border-black">-</td>
                        <td class="border border-black">-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section class="space-y-2">
        <h2 class="text-sm">3. Sistem Penilaian</h2>
        <table class="w-full table-fixed border-collapse border">
            <thead>
                <tr>
                    <th class="border border-black font-normal">Penilaian</th>
                    <th class="border border-black font-normal">Presentase</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($laporan->gradeComponents as $gradeComponent)
                    <tr>
                        <td class="border border-black align-top">{{ $gradeComponent->name }}</td>
                        <td class="border border-black align-top">{{ $gradeComponent?->weight ?? "-" }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="border border-black">-</td>
                        <td class="border border-black">-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section class="space-y-2">
        <h2 class="text-sm">4. Distribusi Nilai</h2>
        <table class="w-full table-auto border-collapse border">
            <thead>
                <tr>
                    <th class="border border-black font-normal">Statistik</th>
                    @foreach ($distribusiNilai as $gradeComponent)
                        <th class="border border-black font-normal">{{ $gradeComponent["name"] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td class="border border-black text-left font-normal">Min</td>
                    @foreach ($distribusiNilai as $key => $value)
                        <td class="border border-black">{{ $value["min"] }}</td>
                    @endforeach
                </tr>

                <tr>
                    <td class="border border-black text-left font-normal">Max</td>
                    @foreach ($distribusiNilai as $key => $value)
                        <td class="border border-black">{{ $value["max"] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border border-black text-left font-normal">Range (Max - Min)</td>
                    @foreach ($distribusiNilai as $key => $value)
                        <td class="border border-black">{{ $value["range"] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border border-black text-left font-normal">Rata-Rata Nilai</td>
                    @foreach ($distribusiNilai as $key => $value)
                        <td class="border border-black">{{ $value["average"] }}</td>
                    @endforeach
                </tr>

                <tr>
                    <td class="border border-black text-left font-normal">Simpangan Baku</td>
                    @foreach ($distribusiNilai as $key => $value)
                        <td class="border border-black">{{ $value["simpangan_baku"] }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <table class="w-full table-fixed border-collapse border">
            <thead>
                <tr>
                    <th class="border border-black font-normal">Nilai</th>
                    <th class="border border-black font-normal">Nilai Maksimal</th>
                    <th class="border border-black font-normal">Nilai Minimal</th>
                    <th class="border border-black font-normal">Jumlah</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($rentangNilai as $rentang)
                    <tr>
                        <td class="border border-black align-top">{{ $rentang["letter"] }}</td>
                        <td class="border border-black align-top">{{ $rentang["max"] }}</td>
                        <td class="border border-black align-top">{{ $rentang["min"] }}</td>
                        <td class="border border-black align-top">{{ $rentang["count"] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>
