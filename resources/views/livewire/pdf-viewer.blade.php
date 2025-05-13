<div wire:init>
    <div class="mb-4 flex justify-end">
        <x-button variant="secondary" wire:click="regeneratePdf" wire:loading.attr="disabled">
            <span wire:loading wire:target="regeneratePdf">
                <x-icons.loading-spinner class="mr-2 h-4 w-4 animate-spin" />
            </span>
            Generate ulang PDF
        </x-button>
    </div>

    @if (! $this->pdfExists || $this->isGenerating)
        <div class="flex h-full items-center justify-center">
            <div class="text-center" id="pdfLoading">
                @if ($this->isGenerating)
                    <div role="status">
                        <x-icons.loading-spinner class="h-8 w-8 animate-spin fill-blue-600 text-gray-200" />
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Mohon tunggu beberapa saat untuk sistem melakukan generate PDF</p>
                @elseif ($this->isFailed)
                    <div class="text-red-600">
                        <p>Gagal generate PDF, Silahkan coba lagi</p>
                        <x-button variant="primary" class="mt-4" wire:click="regeneratePdf">Coba Lagi</x-button>
                    </div>
                @else
                    <div role="status">
                        <x-icons.loading-spinner class="h-8 w-8 animate-spin fill-blue-600 text-gray-200" />
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Mempersiapkan dokumen PDF...</p>
                @endif
            </div>
        </div>
    @else
        <iframe src="{{ route('laporan.pdf', $this->report) }}" width="100%" height="1000px" style="border: none">
            This browser does not support PDFs. Please download the PDF to view it:
            <a href="{{ route('laporan.pdf', $this->report) }}">Download PDF</a>
        </iframe>
    @endif
</div>
