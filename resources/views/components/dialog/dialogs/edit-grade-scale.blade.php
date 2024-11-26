@props([
    "model",
])
<x-dialog x-model="{{$model}}" @open-edit-grade-scale.window="{{$model}} = true">
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>Edit Kualifikasi Angka Mutu</x-dialog.title>
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
            <x-form class="mx-auto w-full" id="editGradeScaleForm" wire:submit="save">
                @csrf

                <x-form.item name="letter">
                    <x-form.label>Penilaian</x-form.label>
                    <x-input x-form:control name="letter" disabled required placeholder="A" wire:model="form.letter" />
                </x-form.item>

                <x-form.item name="max_score">
                    <x-form.label>Nilai Maksimal</x-form.label>
                    <x-input x-form:control name="max_score" required placeholder="50" wire:model="form.max_score" />
                </x-form.item>

                <x-form.item name="min_score">
                    <x-form.label>Nilai Minimal</x-form.label>
                    <x-input x-form:control name="min_score" required placeholder="50" wire:model="form.min_score" />
                </x-form.item>

                <div class="flex justify-end">
                    <x-button type="submit" wire:loading.attr="disabled">Simpan</x-button>
                </div>
            </x-form>
        </div>
    </x-dialog.content>
</x-dialog>
