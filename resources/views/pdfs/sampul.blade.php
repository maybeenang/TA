<h1 class="text-center text-2xl font-bold">PORTOFOLIO PERKULIAHAN</h1>
<div class="mx-auto mt-24 h-[300px] w-[300px]">
    @inlinedImage(asset('itera.png'))
</div>
<div class="mt-16 flex w-full justify-center">
    <table class="w-fit whitespace-nowrap text-xs">
        <tr>
            <td class="w-[200px]">Dosen PJ</td>
            <td class="w-4">:</td>
            <td>{{ $laporan->responsibleLecturer?->user?->name ?? '-' }}</td>
        </tr>
        @foreach ($laporan->lecturers as $lecturer)
            <tr>
                <td>
                    @if ($loop->first)
                        Dosen Pengampu
                    @endif
                </td>
                <td>:</td>
                <td>{{ $lecturer->user->name ?? '-' }}</td>
            </tr>
        @endforeach

        <tr>
            <td>Kelas dan Nama MK</td>
            <td>:</td>
            <td>
                {{ $laporan->classroom->name ?? '-' }} / {{ $laporan->classroom->course->name ?? '-' }}
                ({{ $laporan->classroom->course->code ?? '-' }} / {{ $laporan->classroom->course->credit ?? '-' }})
            </td>
        </tr>
        <tr>
            <td>Semester / Tahun ajaran</td>
            <td>:</td>
            <td>
                {{ $laporan->classroom->academicYear->semester ?? '-' }} /
                {{ $laporan->classroom->academicYear->name ?? '-' }}
            </td>
        </tr>
    </table>
</div>
<div class="absolute bottom-0 w-full text-center">
    <h1 class="text-center text-xl font-bold">
        {{ strtoupper($laporan->classRoom?->course?->programStudi?->name) ?? '' }}
    </h1>
    <h1 class="text-center text-xl font-bold">
        {{ strtoupper($laporan->classRoom?->course?->programStudi?->fakultas?->name) ?? '' }}
    </h1>
    <h1 class="text-center text-xl font-bold">INSTITUT TEKNOLOGI SUMATERA</h1>
    <h1 class="text-center text-xl font-bold">
        {{ date('Y') }}
    </h1>
</div>
