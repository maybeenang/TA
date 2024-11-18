@props([
    "model",
])

@script
    <script type="module">
        document.addEventListener('open-confirm-laporan-verifikasi', () => {
            const laporanId = event.detail;
            Alpine.store('dialogLaporanVerifikasi').reportId = laporanId;
        });

        document.addEventListener('checking-report', () => {
            const laporanId = event.detail?.id;
            Alpine.store('dialogLaporanVerifikasi').isValidating = true;

            Echo.channel(`report-verified-${laporanId}`).listen('ReportVerified', (e) => {
                Alpine.store('dialogLaporanVerifikasi').isValidationDone = true;
                Alpine.store('dialogLaporanVerifikasi').validationResults = e;

                const resultDescEl = document.getElementById('result-desc');
                // clear previous resultDescEl
                resultDescEl.innerHTML = '';
                resultDescEl.classList.remove('text-green-600', 'text-red-600', 'mt-2');
                resultDescEl.innerHTML = e.result.message ?? 'Terjadi kesalahan saat melakukan validasi data laporan';

                if (e.result.result) {
                    resultDescEl.classList.add('text-green-600', 'mt-2');
                } else {
                    resultDescEl.classList.add('text-red-600', 'mt-2');
                    // add ul li
                    const ul = document.createElement('ul');
                    ul.classList.add('list-disc', 'list-inside', 'text-sm', 'text-red-600');
                    e.result?.errors?.map((error) => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        ul.appendChild(li);
                    });
                    resultDescEl.appendChild(ul);
                }
            });
        });

        document.addEventListener('close-modal', () => {
            const data = Alpine.store('dialogLaporanVerifikasi');
            data.isValidating = false;
            data.isValidationDone = false;
            data.reportId = null;
            data.validationResults = {};
        });
    </script>
@endscript

<x-dialog x-model="{{ $model }}" @open-confirm-laporan-verifikasi.window="{{$model}} = true;">
    <x-dialog.content>
        <div class="space-y-4" x-show="!$store.dialogLaporanVerifikasi.isValidating">
            <section>
                <x-dialog.title>Apakah anda yakin?</x-dialog.title>
                <x-dialog.description>
                    Pastikan semua data yang anda masukan sudah benar dan lengkap.
                </x-dialog.description>
            </section>
            <section class="flex justify-end">
                <x-button x-on:click="{{$model}} = false" variant="secondary">Batal</x-button>
                <x-button x-on:click="$dispatch('checking-report', { id: $store.dialogLaporanVerifikasi.reportId })">
                    Ajukan Verifikasi
                </x-button>
            </section>
        </div>

        <div
            x-show="$store.dialogLaporanVerifikasi.isValidating && !$store.dialogLaporanVerifikasi.isValidationDone "
            class="my-8"
        >
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

        <div
            x-show="$store.dialogLaporanVerifikasi.isValidating && $store.dialogLaporanVerifikasi.isValidationDone"
            class="my-8"
        >
            <section>
                <div class="flex h-full items-center justify-center text-justify">
                    <div class="text-center">
                        <div x-show="$store.dialogLaporanVerifikasi.validationResults?.result?.result ?? false">
                            <x-icons.success-circle class="mx-auto h-8 w-8 fill-blue-600 text-gray-200" />
                        </div>

                        <div x-show="!$store.dialogLaporanVerifikasi.validationResults?.result?.result ?? true">
                            <x-icons.failed-circle class="mx-auto h-8 w-8 fill-blue-600 text-gray-200" />
                        </div>
                        <div id="result-desc"></div>
                    </div>
                </div>
            </section>
        </div>
    </x-dialog.content>
</x-dialog>
