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

        <div class="mx-auto flex h-96 w-full" wire:loading>
            <div class="flex h-full items-center justify-center text-center">
                <div role="status">
                    <x-icons.loading-spinner class="h-8 w-8 animate-spin fill-blue-600 text-gray-200" />
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div class="" wire:loading.remove>
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
