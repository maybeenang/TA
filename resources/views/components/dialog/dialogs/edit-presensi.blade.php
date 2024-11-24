@props([
    "model",
])
<x-dialog x-model="{{$model}}" @open-edit-presensi.window="{{$model}} = true">
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>Edit Presensi dan Keaktifan</x-dialog.title>
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

        <div class="mx-auto flex h-80 w-full" wire:loading>
            <div class="flex h-full items-center justify-center text-center">
                <div role="status">
                    <x-icons.loading-spinner class="h-8 w-8 animate-spin fill-blue-600 text-gray-200" />
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div class="" wire:loading.class="hidden">
            <x-form class="mx-auto w-full" id="editPertemuanForm" wire:submit="save">
                @csrf

                <x-form.item name="meeting_name">
                    <x-form.label>Pertemuan</x-form.label>
                    <x-input
                        x-form:control
                        name="meeting_name"
                        placeholder="Minggu ke-"
                        wire:model="editPresensi.meeting_name"
                        disabled
                    />
                </x-form.item>

                <x-form.item name="student_present">
                    <x-form.label>Peserta Hadir</x-form.label>
                    <x-input
                        x-form:control
                        name="student_present"
                        placeholder="0"
                        wire:model="editPresensi.student_present"
                        wire:loading.attr="disabled"
                        tabindex="-1"
                    />
                </x-form.item>

                <x-form.item name="student_active">
                    <x-form.label>Peserta yang aktif</x-form.label>
                    <x-input
                        x-form:control
                        name="student_active"
                        placeholder="0"
                        wire:model="editPresensi.student_active"
                        wire:loading.attr="disabled"
                        tabindex="-1"
                    />
                </x-form.item>

                <div class="flex justify-end">
                    <x-button type="submit" wire:loading.attr="disabled">Simpan</x-button>
                </div>
            </x-form>
        </div>
    </x-dialog.content>
</x-dialog>
