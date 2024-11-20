@props([
    "model",
])
<x-dialog x-model="{{ $model }}" x-on:open-tolak-laporan.window="{{$model}} = true">
    <x-dialog.content
        x-data="{
        reportId: null,
        openTolakLaporan(event) {
            this.reportId = event.detail.reportId;
        }
    }"
        x-on:open-tolak-laporan.window="openTolakLaporan($event)"
        x-on:close-modal.window="reportId = null"
    >
        <x-dialog.header>
            <x-dialog.title>Tolak Laporan</x-dialog.title>
        </x-dialog.header>
        <form wire:submit="tolakLaporan(reportId)" class="my-4 space-y-4" x-ref="formTolakLaporan">
            <div class="">
                <x-label class="text-right">
                    Catatan
                    <span class="text-xs">(optional)</span>
                </x-label>
                <x-textarea class="col-span-3" wire:model="catatan"></x-textarea>
            </div>

            <x-dialog.footer>
                <x-button variant="secondary" @click="$dispatch('close-modal')">Batal</x-button>
                <x-button variant="destructive" type="submit">Tolak</x-button>
            </x-dialog.footer>
        </form>
    </x-dialog.content>
</x-dialog>
