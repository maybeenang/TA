@props([
    "value",
])

@php
    $cpmk = $this->getRowData($value);
@endphp

<div class="flex justify-center" x-data="{
    deleteDialog: false,
}">
    <x-dropdown-menu>
        <x-dropdown-menu.trigger class="rounded-sm bg-white p-2 hover:bg-zinc-100">
            <x-icons.v-three-dots-icon />
        </x-dropdown-menu.trigger>
        <x-dropdown-menu.content>
            <x-dropdown-menu.item @click="$dispatch('open-edit-cpmk', {id: {{$value}}} )">Edit</x-dropdown-menu.item>
            <x-dropdown-menu.item @click="deleteDialog = true">Delete</x-dropdown-menu.item>
        </x-dropdown-menu.content>
    </x-dropdown-menu>

    <!--delete dialog-->
    <x-dialog x-model="deleteDialog">
        <x-dialog.content>
            <x-dialog.header>
                <x-dialog.title>Apakah Anda yakin?</x-dialog.title>

                <x-dialog.footer>
                    <x-button variant="secondary" @click="deleteDialog = false">Batal</x-button>
                    <x-button variant="destructive" wire:click="delete({{$value}})">Hapus</x-button>
                </x-dialog.footer>
            </x-dialog.header>
        </x-dialog.content>
    </x-dialog>
</div>
