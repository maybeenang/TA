<x-app-layout>
    <div class="grid h-fit w-full grid-cols-2 gap-4 md:grid-cols-4">
        <x-card.dashboard-card :number="$academicYearNow->fullName">Tahun Ajaran</x-card.dashboard-card>
        @role("admin")
            <x-card.dashboard-card :number="$dashboardData->laporanCount">Jumlah Laporan</x-card.dashboard-card>
            <x-card.dashboard-card :number="$dashboardData->laporanBelumSelesaiCount">
                Laporan Belum Selesai
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$dashboardData->laporanSudahSelesaiCount">
                Laporan Sudah Selesai
            </x-card.dashboard-card>
        @else
            <x-card.dashboard-card :number="$selfLecturer?->classroomCount">
                Jumlah kelas yang diampu
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$selfLecturer?->laporanBelumSelesaiCount">
                Jumlah Laporan Belum Selesai
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$selfLecturer?->laporanSelesaiCount">
                Jumlah Laporan Sudah Selesai
            </x-card.dashboard-card>
        @endrole
        <x-card.welcome-card />
    </div>
</x-app-layout>
