<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Kelas</span>
        <div class="flex justify-end gap-2">
            <x-import-export type="superadminkelas" label="kelas" />

            @env('local')
                <a href="{{ route('super-admin.scrape-all-kelas') }}">
                    <x-button class="bg-blue-500 hover:bg-blue-600">Input Semua data kelas</x-button>
                </a>
            @endenv

            <a href="{{ route('super-admin.kelas.create') }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Tambah Kelas</x-button>
            </a>
        </div>

        <livewire:table.super-admin.kelas-table />
    </div>
</x-app-layout>
