@props([
    'model',
])

@push('scripts')
    <script type="module">
        Alpine.data('confirmLaporanVerifikasi', () => ({
            reportId: null,
            loading: false,
            result: null,
            msgContainer: document.getElementById('result-desc'),
            onOpenConfirmLaporanVerifikasi({ detail }) {
                this.reportId = detail;
            },

            async submit() {
                this.loading = true;

                try {
                    const response = await axios.patch(
                        route('tenaga-pengajar.laporan.pengajuanVerifikasi', this.reportId),
                    );

                    this.result = response.data;
                } catch (error) {
                    this.result = error.response.data;
                }

                this.loading = false;

                if (this.result.result) {
                    $dispatch('pengajuan-verifikasi-sukses');
                    this.msgContainer.innerHTML = `<p class="mt-2 text-green-700">${this.result.message}</p>`;
                } else {
                    this.msgContainer.innerHTML = `<p class="mt-2 text-red-700">${this.result.message}</p>`;
                }
            },

            onCloseModal() {
                this.reportId = null;
                this.result = null;
            },
        }));
    </script>
@endpush

<x-dialog x-model="{{ $model }}" @open-confirm-laporan-verifikasi.window="{{$model}} = true;">
    <x-dialog.content
        x-data="confirmLaporanVerifikasi"
        @open-confirm-laporan-verifikasi.window="onOpenConfirmLaporanVerifikasi"
        @close-modal.window="onCloseModal"
    >
        {{-- Confirmation Section --}}
        <div class="space-y-4" x-show="loading === false && result === null">
            <section>
                <x-dialog.title>Apakah anda yakin?</x-dialog.title>
                <x-dialog.description>
                    Pastikan semua data yang anda masukan sudah benar dan lengkap.
                </x-dialog.description>
            </section>
            <section class="flex justify-end">
                <x-button x-on:click="{{$model}} = false; $dispatch('close-modal')" variant="secondary">Batal</x-button>
                <x-button x-on:click="submit">Ajukan Verifikasi</x-button>
            </section>
        </div>
        {{-- Loading Section --}}
        <div x-show="loading && !result" class="my-8">
            <section>
                <div class="flex h-full items-center justify-center">
                    <div class="text-center">
                        <div role="status">
                            <x-icons.loading-spinner class="h-8 w-8 animate-spin fill-blue-600 text-gray-200" />
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Tunggu beberapa saat untuk sistem melakukan validasi data laporan</p>
                    </div>
                </div>
            </section>
        </div>

        {{-- Result Section --}}
        <div x-show="loading === false && result" class="my-8">
            <section>
                <div class="flex h-full items-center justify-center text-justify">
                    <div class="text-center">
                        <template x-if="result?.result == true">
                            <x-icons.success-circle class="mx-auto h-8 w-8 fill-blue-600 text-gray-200" />
                        </template>

                        <template x-if="result?.result == false">
                            <x-icons.failed-circle class="mx-auto h-8 w-8 fill-blue-600 text-gray-200" />
                        </template>
                        <div id="result-desc" wire:ignore></div>
                    </div>
                </div>
            </section>
        </div>
    </x-dialog.content>
</x-dialog>
