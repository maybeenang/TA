<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
        x-data
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Pengguna
        </span>

        <div class="flex justify-end gap-2">
            <!-- <x-import-export type="pengguna"  /> -->
            <a href="{{ route('admin.user.create') }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Tambah Pengguna</x-button>
            </a>
        </div>

        <livewire:table.user-table />
    </div>
</x-app-layout>
