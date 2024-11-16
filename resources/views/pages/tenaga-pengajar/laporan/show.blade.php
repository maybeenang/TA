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
                    window.location.href = '{{ route('tenaga-pengajar.laporan.print', $laporan) }}'
                "
                >
                    Unduh Laporan
                </x-button>

                <x-button
                    class="bg-blue-500 hover:bg-blue-600"
                    x-on:click="
                    window.location.href = '{{ route('tenaga-pengajar.laporan.edit', $laporan) }}'
                "
                >
                    Edit Laporan
                </x-button>
            </div>
        </div>

        <section id="pdf-view" class="mx-auto h-[1000px]"></section>
    </div>
    @pushOnce("scripts")
    <script src="https://unpkg.com/pdfobject"></script>
    <script>
        PDFObject.embed('{{ route("tenaga-pengajar.laporan.pdf", $laporan) }}', '#pdf-view', {});
    </script>
    @endPushOnce
</x-app-layout>
