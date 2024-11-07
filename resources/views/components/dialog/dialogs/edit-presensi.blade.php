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

        <div class="">
            <x-form class="mx-auto w-full" id="editPertemuanForm" wire:submit="save">
                @csrf

                <x-form.item name="meeting_name">
                    <x-form.label>Pertemuan</x-form.label>
                    <x-input
                        x-form:control
                        name="meeting_name"
                        placeholder="Pertemuan ke-1"
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
                    />
                </x-form.item>

                <x-form.item name="student_active">
                    <x-form.label>Peserta yang aktif</x-form.label>
                    <x-input
                        x-form:control
                        name="student_active"
                        placeholder="0"
                        wire:model="editPresensi.student_active"
                    />
                </x-form.item>

                <div class="flex justify-end">
                    <x-button type="submit" wire:loading.attr="disabled">Simpan</x-button>
                </div>
            </x-form>
        </div>
    </x-dialog.content>
</x-dialog>
