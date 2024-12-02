<div>
    <div class="mb-4 flex justify-end">
        <x-button variant="secondary" wire:click="regeneratePdf">Generate Ulang PDF</x-button>
    </div>
    @if ($this->isGenerating)
        <div
            class="flex h-full items-center justify-center"
            @pdf-failed.window="$refs.pdfLoading.innerHTML = 'Gagal generate PDF, Silahkan coba lagi'; $refs.pdfLoading.classList.add('text-red-600')"
        >
            <div class="text-center" x-ref="pdfLoading">
                <div role="status">
                    <x-icons.loading-spinner class="h-8 w-8 animate-spin fill-blue-600 text-gray-200" />
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Generating PDF...</p>
            </div>
        </div>
    @else
        <iframe src="{{ route('laporan.pdf', $report) }}" width="100%" height="1000px" style="border: none">
            This browser does not support PDFs. Please download the PDF to view it:
            <a href="{{ route('laporan.pdf', $report) }}">Download PDF</a>
        </iframe>
    @endif

    @script
        <script type="module">
            await $wire.$call('checkPdfStatus');
            const reportId = await $wire.$call('getReportIdProperty');

            const ev = new EventSource(`${window.mercureUrl}?topic=${encodeURIComponent('pdf-generated-' + reportId)}`);

            console.log('Connecting to Mercure hub');

            ev.onopen = (e) => {
                console.log('Connected to Mercure hub');
            };

            ev.onmessage = async (e) => {
                const data = JSON.parse(e.data);
                console.log(data);
                if (data.data.status == true) {
                    await $wire.$call('pdfHasGenerated');
                } else {
                    console.error('Failed to generate PDF');
                    window.dispatchEvent(new CustomEvent('pdf-failed'));
                }
            };

            ev.onerror = (e) => {
                console.error('Failed to connect to Mercure hub');
                window.dispatchEvent(new CustomEvent('pdf-failed'));
            };
        </script>
    @endscript
</div>
