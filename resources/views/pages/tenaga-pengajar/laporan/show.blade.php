<x-app-layout>
    <x-alert.flash />
    <div
        class="max-w-full space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Laporan
        </span>

        <section id="pdf-view" class="mx-auto h-[1000px]"></section>
    </div>
    @pushOnce("scripts")
    <script src="https://unpkg.com/pdfobject"></script>
    <script>
        PDFObject.embed('{{ asset("storage/sampul.pdf") }}', '#pdf-view', {
            page: 4,
        });
    </script>
    @endPushOnce
</x-app-layout>
