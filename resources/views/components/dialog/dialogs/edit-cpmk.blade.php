@props([
    'model',
])
<x-dialog x-model="{{$model}}" @open-edit-cpmk.window="{{$model}} = true">
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>Edit CPMK</x-dialog.title>
        </x-dialog.header>

        <div class="mx-auto flex h-96 w-full" wire:loading>
            <div class="flex h-full items-center justify-center text-center">
                <div role="status">
                    <x-icons.loading-spinner class="h-8 w-8 animate-spin fill-blue-600 text-gray-200" />
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div class="" wire:loading.remove>
            @if ($errors->any())
                <x-alert variant="destructive" class="my-4 rounded-sm">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <x-form class="mx-auto w-full" id="editForm" wire:submit="save">
                @csrf

                <x-form.item name="code">
                    <x-form.label>Kode CPMK</x-form.label>
                    <x-input x-form:control name="code" required placeholder="CPMK1" wire:model="form.code" />
                </x-form.item>

                <x-form.item name="description">
                    <x-form.label>Deskripsi</x-form.label>
                    <x-textarea
                        placeholder="Mahasiswa mampu menggunakan perangkat keras dan lunak dalam sistem digital"
                        class="min-h-64"
                        wire:model="form.description"
                        required
                    />
                </x-form.item>

                <x-form.item name="criteria">
                    <x-form.label>Kriteria dan Bentuk</x-form.label>

                    <x-select id="criteria" name="criteria" class="" wire:model="form.criteria">
                        <option value="" disabled>Pilih Kriteria</option>
                        @foreach ($this->laporan->gradeComponents as $gradeComponent)
                            <option
                                value="{{ $gradeComponent->name }}"
                                @selected($gradeComponent->name == $this->form->criteria)
                            >
                                {{ $gradeComponent->name }}
                            </option>
                        @endforeach
                    </x-select>
                </x-form.item>

                <x-form.item name="average_score">
                    <x-form.label>Rata Rata Nilai</x-form.label>
                    <x-input
                        type="number"
                        step="0.01"
                        x-form:control
                        name="average_score"
                        placeholder="80"
                        wire:model="form.average_score"
                    />
                </x-form.item>

                <div class="flex justify-end">
                    <x-button type="submit" wire:loading.attr="disabled">Simpan</x-button>
                </div>
            </x-form>
        </div>
    </x-dialog.content>
</x-dialog>
