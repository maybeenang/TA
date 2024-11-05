@props([
    "value",
])

@php
    $cpmk = $this->getRowData($value);
@endphp

<div class="flex justify-center" x-data="{
    deleteDialog: false,
    editDialog: false,
}">
    <x-dropdown-menu>
        <x-dropdown-menu.trigger class="rounded-sm bg-white p-2 hover:bg-zinc-100">
            <x-icons.v-three-dots-icon />
        </x-dropdown-menu.trigger>
        <x-dropdown-menu.content>
            <x-dropdown-menu.item @click="editDialog = true">Edit</x-dropdown-menu.item>
            <x-dropdown-menu.item @click="deleteDialog = true">Delete</x-dropdown-menu.item>
        </x-dropdown-menu.content>
    </x-dropdown-menu>

    <!--edit dialog-->
    <x-dialog x-model="editDialog">
        <x-dialog.content>
            <x-dialog.header>
                <x-dialog.title>Edit CPMK</x-dialog.title>

                <div class="mb-8">
                    <x-form class="mx-auto max-w-md" method="POST" action="{{ route('admin.kelas.store') }}">
                        @csrf

                        <x-form.item name="code">
                            <x-form.label>Kode CPMK</x-form.label>
                            <x-input x-form:control required name="code" placeholder="CPMK1" :value="old('name')" />
                            <x-form.message />
                        </x-form.item>

                        <x-form.item name="description">
                            <x-form.label>Deskripsi</x-form.label>
                            <x-textarea
                                placeholder="Mahasiswa mampu menggunakan perangkat keras dan lunak dalam sistem digital"
                                class="min-h-64"
                            />
                            <x-form.message />
                        </x-form.item>

                        <x-form.item name="criteria">
                            <x-form.label>Kriteria dan Bentuk</x-form.label>
                            <x-input
                                x-form:control
                                required
                                name="criteria"
                                placeholder="UTS UAS"
                                :value="old('name')"
                            />
                            <x-form.message />
                        </x-form.item>

                        <x-form.item name="average_score">
                            <x-form.label>Rata Rata Nilai</x-form.label>
                            <x-input
                                x-form:control
                                required
                                name="average_score"
                                placeholder="80"
                                :value="old('name')"
                            />
                            <x-form.message />
                        </x-form.item>
                    </x-form>
                </div>

                <x-dialog.footer>
                    <x-button wire:click="">Simpan</x-button>
                </x-dialog.footer>
            </x-dialog.header>
        </x-dialog.content>
    </x-dialog>

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
