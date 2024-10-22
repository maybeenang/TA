<x-app-layout>
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">

        <span class="text-sm flex items-center gap-1">
            <x-icons.backpack-icon />
            Kelas
        </span>
        <div class="flex justify-end">
            <x-button class="bg-blue-500 hover:bg-blue-600"
                x-on:click="
                    window.location.href = '{{ route('admin.kelas.create') }}'
                ">
                Tambah Kelas
            </x-button>
        </div>

        <livewire:table.kelas-table />

    </div>
</x-app-layout>
