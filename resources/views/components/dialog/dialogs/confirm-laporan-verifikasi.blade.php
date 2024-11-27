@props([
    "model",
])

@script
    <script type="module">
        Alpine.data('reportVerification', () => ({
            //echoChannel: null,
            ev: null,
            resultDescEl: null,

            init() {
                this.resultDescEl = document.getElementById('result-desc');
                this.setupEventListeners();

                // Return cleanup function
                return () => {
                    this.cleanupEventListeners();
                };
            },

            setupEventListeners() {
                const handleOpen = this.handleOpenDialog.bind(this);
                const handleCheck = this.handleCheckingReport.bind(this);
                const handleClose = this.handleCloseModal.bind(this);

                // Store references untuk cleanup
                this._listeners = {
                    open: handleOpen,
                    check: handleCheck,
                    close: handleClose,
                };

                document.addEventListener('open-confirm-laporan-verifikasi', (e) => {
                    handleOpen(e);
                });
                document.addEventListener('checking-report', (e) => {
                    handleCheck(e);
                });
                document.addEventListener('close-modal', (e) => {
                    handleClose(e);
                });
            },

            cleanupEventListeners() {
                // Cleanup semua event listeners
                if (this._listeners) {
                    document.removeEventListener('open-confirm-laporan-verifikasi', this._listeners.open);
                    document.removeEventListener('checking-report', this._listeners.check);
                    document.removeEventListener('close-modal', this._listeners.close);
                    this._listeners = null;
                }

                this.cleanupPreviousEcho();
            },

            handleOpenDialog(event) {
                const laporanId = event.detail;
                console.log('Opening dialog for report with ID:', laporanId);
                Alpine.store('dialogLaporanVerifikasi').reportId = laporanId;
            },

            handleCheckingReport(event) {
                const laporanId = event.detail?.id;
                console.log('Checking report with ID:', laporanId);
                const store = Alpine.store('dialogLaporanVerifikasi');

                store.isValidating = true;
                this.cleanupPreviousEcho();
                this.setupEchoListener(laporanId);
            },

            handleCloseModal() {
                const store = Alpine.store('dialogLaporanVerifikasi');
                this.resetState(store);
                this.cleanupPreviousEcho();
            },

            cleanupPreviousEcho() {
                if (this.ev) {
                    this.ev.close();
                    this.ev = null;
                }
                //if (this.echoChannel) {
                //    // Properly leave/unsubscribe from the channel
                //    this.echoChannel.stopListening('ReportVerified');
                //    Echo.leaveChannel(this.echoChannel.name);
                //    this.echoChannel = null;
                //}
            },

            setupEchoListener(laporanId) {
                const channelName = `report-verified-${laporanId}`;
                //this.echoChannel = Echo.channel(channelName);

                this.ev = new EventSource(`${window.mercureUrl}?topic=${encodeURIComponent(channelName)}`);

                this.ev.onmessage = (e) => {
                    const data = JSON.parse(e.data);
                    this.handleReportVerified(data.data);
                };

                this.ev.onerror = (e) => {
                    console.error('Failed to connect to Mercure hub');
                    this.cleanupPreviousEcho();
                };

                //this.echoChannel.listen('ReportVerified', (e) => {
                //    this.handleReportVerified(e);
                //});
            },

            handleReportVerified(e) {
                const store = Alpine.store('dialogLaporanVerifikasi');
                store.isValidationDone = true;
                store.validationResults = e;

                this.updateResultDisplay(e.result);

                // Cleanup Echo setelah mendapat response
                this.cleanupPreviousEcho();
            },

            updateResultDisplay(result) {
                if (!this.resultDescEl) return;

                // Reset previous state
                this.resultDescEl.innerHTML = '';
                this.resultDescEl.classList.remove('text-green-600', 'text-red-600', 'mt-2');

                // Set base message
                this.resultDescEl.innerHTML =
                    result.message ?? 'Terjadi kesalahan saat melakukan validasi data laporan';

                if (result.result) {
                    this.resultDescEl.classList.add('text-green-600', 'mt-2');
                } else {
                    this.handleValidationErrors(result.errors);
                }
            },

            handleValidationErrors(errors) {
                this.resultDescEl.classList.add('text-red-600', 'mt-2');

                const ul = document.createElement('ul');
                ul.classList.add('list-disc', 'list-inside', 'text-sm', 'text-red-600');
            },

            resetState(store) {
                store.isValidating = false;
                store.isValidationDone = false;
                store.reportId = null;
                store.validationResults = {};

                if (this.resultDescEl) {
                    this.resultDescEl.innerHTML = '';
                    this.resultDescEl.classList.remove('text-green-600', 'text-red-600', 'mt-2');
                }
            },
        }));
    </script>
@endscript

<x-dialog x-model="{{ $model }}" @open-confirm-laporan-verifikasi.window="{{$model}} = true;">
    <x-dialog.content x-data="reportVerification">
        {{-- Confirmation Section --}}
        <div class="space-y-4" x-show="!$store.dialogLaporanVerifikasi.isValidating">
            <section>
                <x-dialog.title>Apakah anda yakin?</x-dialog.title>
                <x-dialog.description>
                    Pastikan semua data yang anda masukan sudah benar dan lengkap.
                </x-dialog.description>
            </section>
            <section class="flex justify-end">
                <x-button x-on:click="{{$model}} = false; $dispatch('close-modal')" variant="secondary">Batal</x-button>
                <x-button x-on:click="$dispatch('checking-report', { id: $store?.dialogLaporanVerifikasi?.reportId})">
                    Ajukan Verifikasi
                </x-button>
            </section>
        </div>

        {{-- Loading Section --}}
        <div
            x-show="$store.dialogLaporanVerifikasi.isValidating && !$store.dialogLaporanVerifikasi.isValidationDone"
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

        {{-- Result Section --}}
        <div
            x-show="$store.dialogLaporanVerifikasi.isValidating && $store.dialogLaporanVerifikasi.isValidationDone"
            class="my-8"
        >
            <section>
                <div class="flex h-full items-center justify-center text-justify">
                    <div class="text-center">
                        <template x-if="$store.dialogLaporanVerifikasi.validationResults?.result?.result">
                            <x-icons.success-circle class="mx-auto h-8 w-8 fill-blue-600 text-gray-200" />
                        </template>

                        <template x-if="!$store.dialogLaporanVerifikasi.validationResults?.result?.result">
                            <x-icons.failed-circle class="mx-auto h-8 w-8 fill-blue-600 text-gray-200" />
                        </template>
                        <div id="result-desc"></div>
                    </div>
                </div>
            </section>
        </div>
    </x-dialog.content>
</x-dialog>
