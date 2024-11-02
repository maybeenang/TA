<x-app-layout>
    <x-alert.flash />
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.backpack-icon />
            Laporan
        </span>

        <div class="flex justify-end">
            <x-button class="bg-blue-500 hover:bg-blue-600"
                x-on:click="
                    window.location.href = '{{ route('tenaga-pengajar.laporan.select') }}'
                ">
                Buat Laporan
            </x-button>
        </div>

        <div class="flex justify-end">
        </div>

        <livewire:table.tenaga-pengajar.laporan-table />
    </div>
</x-app-layout>
