<div class="space-y-4 text-xs">
    <section class="space-y-2">
        <h2 class="text-sm">5. Statistik Kelas</h2>
        <div class="flex gap-2">
            <table class="w-full table-auto border-collapse border">
                <thead>
                    <tr>
                        <th class="border border-black font-normal">Pertemuan (Minggu)</th>
                        <th class="border border-black font-normal">Jumlah Peseta Hadir</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($laporan->attendanceAndActivities as $pertemuan)
                        <tr>
                            <td class="border border-black align-top">{{ $pertemuan->meeting_name }}</td>
                            <td class="border border-black align-top">{{ $pertemuan->student_present ?? "0" }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="w-full table-auto border-collapse border">
                <thead>
                    <tr>
                        <th class="border border-black font-normal">Pertemuan (Minggu)</th>
                        <th class="border border-black font-normal">Jumlah Peserta yang Aktif</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($laporan->attendanceAndActivities as $pertemuan)
                        <tr>
                            <td class="border border-black align-top">{{ $pertemuan->meeting_name }}</td>
                            <td class="border border-black align-top">{{ $pertemuan->student_active ?? "0" }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include("pdfs.chart-peserta-hadir")
    </section>
</div>
