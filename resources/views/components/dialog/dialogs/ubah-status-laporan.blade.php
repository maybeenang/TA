@props(['model', 'value' => null])
<x-dialog x-model="{{ $model }}">
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>Ubah Status Laporan</x-dialog.title>
        </x-dialog.header>

        <form wire:submit="changeReportStatus({{ $value }})">

            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <x-label htmlFor="reportStatusName" class="text-right">Status Laporan</x-label>
                    <x-select autofocus id="reportStatusName" name="reportStatusName" class="col-span-3"
                        wire:model="reportStatusName">
                        <option value="">Pilih Status Laporan</option>
                        @foreach ($this->getAllReportStatuses() as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                        @endforeach
                    </x-select>
                </div>

            </div>

            <x-dialog.footer>
                <x-button type="submit">Save changes</x-button>
            </x-dialog.footer>
        </form>

    </x-dialog.content>
</x-dialog>
