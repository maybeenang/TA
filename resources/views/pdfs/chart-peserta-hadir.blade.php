<div class="mx-auto h-[300px] max-w-xl border border-black">
    <canvas id="pesertaHadirChart"></canvas>
</div>

<div class="mx-auto h-[300px] max-w-xl border border-black">
    <canvas id="pesertaAktifChart"></canvas>
</div>

@push("scripts")
    <script>
        const dataHadir = {
            labels: @js($laporan->attendanceAndActivities->pluck("meeting_name")),
            datasets: [
                {
                    data: @js($laporan->attendanceAndActivities->pluck("student_present") ?? "[]"),
                    backgroundColor: '#003366',
                    borderColor: '#003366',
                    borderWidth: 1,
                },
            ],
        };

        const dataAktif = {
            labels: @js($laporan->attendanceAndActivities->pluck("meeting_name")),
            datasets: [
                {
                    data: @js($laporan->attendanceAndActivities->pluck("student_active") ?? "[]"),
                    backgroundColor: '#003366',
                    borderColor: '#003366',
                    borderWidth: 1,
                },
            ],
        };

        const config = (title) => {
            return {
                type: 'bar',
                data: title === 'Jumlah Peserta Hadir' ? dataHadir : dataAktif,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false, // Menonaktifkan semua animasi
                    hover: {
                        mode: null, // Menonaktifkan interaksi hover
                    },
                    events: [], // Menonaktifkan semua events
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: {{ $laporan->classroom->students->count() }},
                            ticks: {
                                stepSize: {{ $laporan->classroom->students->count() / 5 }},
                                font: {
                                    size: 12,
                                },
                            },
                            title: {
                                display: true,
                                text: title,
                            },
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 12,
                                },
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            enabled: false, // Menonaktifkan tooltips
                        },
                        title: {
                            display: false,
                        },
                    },
                },
            };
        };

        new Chart(document.getElementById('pesertaHadirChart'), config('Jumlah Peserta Hadir'));

        new Chart(document.getElementById('pesertaAktifChart'), config('Jumlah Peserta Aktif'));
    </script>
@endpush
