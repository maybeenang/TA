<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Kelas</span>
        <div class="flex justify-end gap-2">
            <a href="{{ route('super-admin.kelas.scrape-data') }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Scrape Data</x-button>
            </a>
            <a href="{{ route('super-admin.kelas.create') }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Tambah Kelas</x-button>
            </a>
        </div>

        <livewire:table.super-admin.kelas-table />
    </div>
</x-app-layout>
