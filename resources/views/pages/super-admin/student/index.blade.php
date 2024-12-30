<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Mahasiswa</span>

        <div class="flex justify-end">
            <a href="{{ route('super-admin.student.create') }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Tambah Mahasiswa</x-button>
            </a>
        </div>

        <livewire:table.super-admin.student-table />
    </div>
</x-app-layout>
