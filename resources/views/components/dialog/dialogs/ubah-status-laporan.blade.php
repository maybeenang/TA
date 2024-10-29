@props(['model', 'value' => null])
<x-dialog x-model="{{ $model }}">
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>Ubah Status Laporan</x-dialog.title>
        </x-dialog.header>

        <form wire:submit="addLecture({{ $value }})">

            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <x-label htmlFor="username" class="text-right">Tenaga Pengajar</x-label>
                    <x-select autofocus id="lecturer_id" name="lecturer_id" class="col-span-3" wire:model="lecturerId">
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
