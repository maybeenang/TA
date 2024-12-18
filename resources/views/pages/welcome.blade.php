<x-app-layout>
    <div class="grid h-fit w-full grid-cols-2 gap-4 md:grid-cols-4">
        <x-card.dashboard-card :number="$academicYearNow->fullName" class="bg-blue-500 text-white">
            Tahun Ajaran
        </x-card.dashboard-card>
        @role('admin')
            <x-card.dashboard-card :number="$dashboardData->laporanCount" class="bg-green-500 text-white">
                Jumlah Laporan
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$dashboardData->laporanBelumSelesaiCount" class="bg-amber-500 text-white">
                Laporan Belum Selesai
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$dashboardData->laporanSudahSelesaiCount" class="bg-red-500 text-white">
                Laporan Sudah Selesai
            </x-card.dashboard-card>
        @else
            <x-card.dashboard-card :number="$selfLecturer?->classroomCount" class="bg-green-500 text-white">
                Jumlah kelas yang diampu
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$selfLecturer?->laporanBelumSelesaiCount" class="bg-amber-500 text-white">
                Jumlah Laporan Belum Selesai
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$selfLecturer?->laporanSelesaiCount" class="bg-red-500 text-white">
                Jumlah Laporan Sudah Selesai
            </x-card.dashboard-card>
        @endrole
        <x-card.welcome-card />

        <x-card.dashboard-informasi-card />

        @role('admin')
            <livewire:grid.admin-verifikasi-laporan />
        @endrole

        <livewire:grid.laporan-terakhir />
    </div>
</x-app-layout>
