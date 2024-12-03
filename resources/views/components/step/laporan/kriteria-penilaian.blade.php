<div class="min-h-2 space-y-2">
    <h3 class="text-2xl font-semibold" id="kriteria-penilaian">Kriteria Penilaian</h3>


    <div class="flex flex-col items-start gap-4 md:flex-row md:justify-between">
        <x-button.index @click="$dispatch('open-create-grade-component')">Tambah Komponen Penilaian</x-button.index>
    </div>

    <div class="md:flex md:justify-between">
        <div class="max-w-fit">
            <livewire:table.tenaga-pengajar.grade-component-table :laporan="$laporan" />
        </div>

        <div class="max-w-fit">
            <livewire:table.tenaga-pengajar.grade-scale-table :laporan="$laporan" />
        </div>
    </div>
</div>
