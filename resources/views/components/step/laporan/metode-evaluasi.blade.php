<div class="min-h-2 space-y-2" x-data="{ createDialog: false }">
    <h3 class="text-2xl font-semibold" id="metode-evaluasi">Metode Evaluasi</h3>

    <div class="flex justify-end">
        <x-button.index @click="createDialog = true">Tambah Metode Evaluasi</x-button.index>
    </div>

    <livewire:table.tenaga-pengajar.cpmk-table :laporan="$laporan" />

    <!--dialog tambah metode evaluasi-->
    <x-dialog x-model="createDialog">
        <x-dialog.content>
            <x-dialog.header>
                <x-dialog.title>Tambah Metode Evaluasi</x-dialog.title>
                <x-dialog.footer>
                    <x-button variant="secondary" type="submit" @click="createDialog = false">Batal</x-button>

                    <x-button variant="destructive" type="submit">Hapus</x-button>
                </x-dialog.footer>
            </x-dialog.header>
        </x-dialog.content>
    </x-dialog>
</div>
