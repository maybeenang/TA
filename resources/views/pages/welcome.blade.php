<x-app-layout>
    <div class="grid h-fit w-full grid-cols-2 gap-4 md:grid-cols-4">
        @role('admin|gkmp|kaprodi|super-admin')
            <x-card.dashboard-card :number="$academicYearNow->fullName" class="bg-blue-500 text-white">
                Tahun Ajaran
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$adminDashboardData->jumlahLaporan" class="bg-green-500 text-white">
                Jumlah Laporan
            </x-card.dashboard-card>
            <x-card.dashboard-card
                :number="$adminDashboardData->jumlahLaporanBelumSelesai"
                class="bg-amber-500 text-white"
            >
                Laporan Belum Selesai
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="$adminDashboardData->jumlahLaporanSelesai" class="bg-red-500 text-white">
                Laporan Sudah Selesai
            </x-card.dashboard-card>
        @else
            <x-card.dashboard-card :number="$academicYearNow->fullName" class="bg-blue-500 text-white">
                Tahun Ajaran
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="0" class="bg-green-500 text-white">Jumlah Laporan</x-card.dashboard-card>
            <x-card.dashboard-card :number="0" class="bg-amber-500 text-white">
                Laporan Belum Selesai
            </x-card.dashboard-card>
            <x-card.dashboard-card :number="0" class="bg-red-500 text-white">
                Laporan Sudah Selesai
            </x-card.dashboard-card>
        @endrole

        <x-card.welcome-card />

        <x-card.dashboard-informasi-card />
    </div>

    <div class="w-full bg-zinc-300">
        <img src="{{ Vite::asset('resources/images/alur.png') }}" class="w-full" />
    </div>
</x-app-layout>
