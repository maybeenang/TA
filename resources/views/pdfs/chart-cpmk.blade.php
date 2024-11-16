<div class="mx-auto h-[300px] max-w-xl border border-black">
    <canvas id="myChart"></canvas>
</div>

@push("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const data = {
                labels: @js($laporan->cpmks->pluck("code")),
                datasets: [
                    {
                        label: 'Angka Mutu',
                        data: @js($laporan->cpmks->pluck("average_score")->map(fn ($score) => $laporan->convertToGradeScale($score)->score)),
                        backgroundColor: '#003366', // Warna biru tua seperti di gambar
                        borderColor: '#003366',
                        borderWidth: 1,
                        barThickness: 40, // Mengatur ketebalan bar
                    },
                ],
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    indexAxis: 'y', // Membuat bar horizontal
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false, // Menonaktifkan animasi
                    hover: {
                        mode: null, // Menonaktifkan hover
                    },
                    events: [], // Menonaktifkan semua events
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 4,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 12,
                                },
                            },
                            grid: {
                                drawOnChartArea: true,
                                color: '#E5E5E5',
                            },
                            title: {
                                display: true,
                                text: 'Angka Mutu',
                                font: {
                                    size: 14,
                                },
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 12,
                                },
                            },
                            grid: {
                                display: false,
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
                    layout: {
                        padding: {
                            left: 10,
                            right: 30,
                            top: 10,
                            bottom: 10,
                        },
                    },
                },
            };

            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, config);
        });
    </script>
@endpush
