<div class="min-h-2 space-y-2">
    <h3 class="text-2xl font-semibold" id="metode-evaluasi">Metode Evaluasi</h3>

    <div class="flex justify-end">
        <x-button.index @click="$dispatch('open-create-cpmk')">Tambah Metode Evaluasi</x-button.index>
    </div>

    <livewire:table.tenaga-pengajar.cpmk-table :laporan="$laporan" />
</div>
