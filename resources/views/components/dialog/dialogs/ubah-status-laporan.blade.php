@props([
    "model",
])
<x-dialog
    x-model="{{ $model }}"
    @open-ubah-status-laporan.window="
        {{$model}} = true;
        const reportId = $event.detail.reportId
        $wire.selectedChangeReport = reportId
        "
>
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>Ubah Status Laporan</x-dialog.title>
            <div class="rounded border border-red-300 bg-red-50 p-2 text-red-500">
                <p>Aksi ini hanya digunakan jika ingin mengubah status saat terjadi kesalahan</p>
            </div>
        </x-dialog.header>

        <form wire:submit="changeReportStatus" x-data="{ showNote: false }">
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <x-label htmlFor="reportStatusName" class="text-right">Status Laporan</x-label>
                    <x-select
                        autofocus
                        id="reportStatusName"
                        name="reportStatusName"
                        class="col-span-3"
                        wire:model="reportStatusName"
                        x-ref="reportStatusName"
                        x-on:change="
                            $refs.reportStatusName.value === 'ditolak'
                                ? (showNote = true)
                                : (showNote = false)
                        "
                    >
                        <option value="">Pilih Status Laporan</option>
                        @foreach ($this->getAllReportStatuses() as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                        @endforeach
                    </x-select>
                </div>

                <template x-if="showNote">
                    <div class="">
                        <x-label class="text-right">
                            Catatan
                            <span class="text-xs">(optional)</span>
                        </x-label>
                        <x-textarea class="col-span-3" wire:model="reportNote"></x-textarea>
                    </div>
                </template>
            </div>

            <x-dialog.footer>
                <x-button type="submit">Save changes</x-button>
            </x-dialog.footer>
        </form>
    </x-dialog.content>
</x-dialog>
