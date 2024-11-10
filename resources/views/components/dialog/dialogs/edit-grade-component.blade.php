@props([
    "model",
])
<x-dialog x-model="{{$model}}" @open-edit-grade-component.window="{{$model}} = true">
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>Edit Komponen Penilaian</x-dialog.title>
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
            <x-form class="mx-auto w-full" id="editGradeComponent" wire:submit="saveEdit">
                @csrf

                <x-form.item name="name">
                    <x-form.label>Nama Penilaian</x-form.label>
                    <x-input x-form:control name="name" required placeholder="UTS" wire:model="editForm.name" />
                </x-form.item>

                <x-form.item name="weight">
                    <x-form.label>Persentase</x-form.label>
                    <x-input x-form:control name="weight" placeholder="20" wire:model="editForm.weight" />
                </x-form.item>

                <div class="flex justify-end">
                    <x-button type="submit" wire:loading.attr="disabled">Simpan</x-button>
                </div>
            </x-form>
        </div>
    </x-dialog.content>
</x-dialog>
