<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Laporan</span>

        <div class="flex justify-end">
            <a href="{{ route('super-admin.laporan.create') }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Tambah Laporan</x-button>
            </a>
        </div>

        <livewire:table.super-admin.laporan-table />
    </div>
</x-app-layout>
