<x-app-layout>
    <x-alert.flash />
    <div
        class="max-w-full space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Laporan
        </span>

        <div class="flex justify-end">
            <div>
                <x-button
                    class="bg-blue-500 hover:bg-blue-600"
                    x-on:click="
                    window.location.href = '{{ route('laporan.print', $laporan) }}'
                "
                >
                    Unduh Laporan
                </x-button>
            </div>
        </div>

        <livewire:pdf-viewer :report="$laporan" />
    </div>
</x-app-layout>
