<x-app-layout>
    <x-alert.flash />
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.backpack-icon />
            Kelas
        </span>
        <div class="flex justify-end">
        </div>

        <livewire:table.tenaga-pengajar.kelas-table />

    </div>
</x-app-layout>
