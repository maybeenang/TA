<div>
    @if ($this->isGenerating)
        <div class="flex h-full items-center justify-center">
            <div class="text-center">
                <div role="status">
                    <x-icons.loading-spinner class="h-8 w-8 animate-spin fill-blue-600 text-gray-200" />
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Generating PDF...</p>
            </div>
        </div>
    @else
        <iframe src="{{ route("laporan.pdf", $report) }}" width="100%" height="1000px" style="border: none">
            This browser does not support PDFs. Please download the PDF to view it:
            <a href="{{ route("laporan.pdf", $report) }}">Download PDF</a>
        </iframe>
    @endif

    @script
        <script type="module">
            const reportId = await $wire.$call('getReportIdProperty');
            console.log('reportId', reportId);
            Echo.channel(`pdf-generated-${reportId}`).listen('PDFGenerated', (e) => {
                console.log('PDFGenerated', e);
                $wire.$call('checkPdfStatus');
            });

            $wire.$call('checkPdfStatus');
        </script>
    @endscript
</div>
