@props([
    "model",
])
<x-dialog x-model="{{$model}}" @open-create-cpmk.window="{{$model}} = true">
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>Tambah CPMK</x-dialog.title>
        </x-dialog.header>

        @if ($errors->any())
            <x-alert variant="destructive" class="my-4 rounded-sm">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <div class="">
            <x-form class="mx-auto w-full" id="createForm" wire:submit="saveCreate">
                @csrf

                <x-form.item name="code">
                    <x-form.label>Kode CPMK</x-form.label>
                    <x-input x-form:control name="code" required placeholder="CPMK1" wire:model="createForm.code" />
                </x-form.item>

                <x-form.item name="description">
                    <x-form.label>Deskripsi</x-form.label>
                    <x-textarea
                        placeholder="Mahasiswa mampu menggunakan perangkat keras dan lunak dalam sistem digital"
                        class="min-h-64"
                        wire:model="createForm.description"
                        required
                    />
                </x-form.item>

                <x-form.item name="criteria">
                    <x-form.label>Kriteria dan Bentuk</x-form.label>
                    <x-input
                        x-form:control
                        required
                        name="criteria"
                        placeholder="UTS UAS"
                        wire:model="createForm.criteria"
                    />
                </x-form.item>

                <x-form.item name="average_score">
                    <x-form.label>Rata Rata Nilai</x-form.label>
                    <x-input
                        x-form:control
                        name="average_score"
                        placeholder="80"
                        wire:model="createForm.average_score"
                    />
                </x-form.item>

                <div class="flex justify-end">
                    <x-button type="submit" wire:loading.attr="disabled">Simpan</x-button>
                </div>
            </x-form>
        </div>
    </x-dialog.content>
</x-dialog>
