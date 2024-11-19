<x-app-layout>
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Edit Laporan
        </span>

        <div class="space-y-4 rounded-md border-2 border-l-8 border-zinc-100 border-l-red-500 p-2">
            <div class="mb-4">
                <p>{{ $msg }}</p>
            </div>
            <a href="{{ route("tenaga-pengajar.laporan.show", $laporan) }}">
                <x-button.index>Lihat Laporan</x-button.index>
            </a>
            <a href="{{ route("laporan.print", $laporan) }}">
                <x-button.index variant="secondary">Unduh PDF Laporan</x-button.index>
            </a>
        </div>
    </div>
</x-app-layout>
