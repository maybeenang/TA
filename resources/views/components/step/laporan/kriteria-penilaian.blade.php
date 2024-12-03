<div class="min-h-2 space-y-2">
    <h3 class="text-2xl font-semibold" id="kriteria-penilaian">Kriteria Penilaian</h3>

    <div class="space-y-4 rounded-md border border-l-8 border-zinc-300 border-l-red-500 p-2">
        <p class="text-sm">
            Anda dapat melakukan export template penilaian untuk mendownload file excel yang berisikan: komponen
            penilaian, rentang nilai, dan juga nilai nilai mahasiswa. Setelah mengisi template tersebut, Anda dapat
            mengimportnya kembali ke sistem. Dan sistem akan mengolah data tersebut untuk menampilkan komponen
            penilaian, rentang nilai, dan nilai mahasiswa secara otomatis.
            <span class="block font-semibold">
                Catatan: Jika Anda mengimport template penilaian, data yang sudah ada akan dihapus dan digantikan
            </span>
        </p>
        <div class="">
            <x-button.index variant="outline" @click="">Export template penilaian</x-button.index>
            <x-button.index>Import template penilaian</x-button.index>
        </div>
    </div>

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
