<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Laporan
        </span>

        <div class="flex justify-end">
            <x-button
                class="bg-blue-500 hover:bg-blue-600"
                x-on:click="
                    window.location.href = '{{ route('tenaga-pengajar.laporan.select') }}'
                "
            >
                Buat Laporan
            </x-button>
        </div>

        <div class="flex justify-end"></div>

        <livewire:table.tenaga-pengajar.laporan-table />
    </div>
</x-app-layout>
