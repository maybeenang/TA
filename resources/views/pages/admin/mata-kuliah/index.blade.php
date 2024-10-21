<x-app-layout>
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">

        <span class="text-sm flex items-center gap-1">
            <x-icons.person-icon />
            Mata Kuliah
        </span>

        <div class="flex justify-end">
            <x-button class="bg-blue-500 hover:bg-blue-600" x-data
                x-on:click="
                    window.location.href = '{{ route('admin.mata-kuliah.create') }}'
                ">
                Tambah Mata Kuliah
            </x-button>
        </div>

        <livewire:table.mata-kuliah-table />

    </div>

</x-app-layout>
