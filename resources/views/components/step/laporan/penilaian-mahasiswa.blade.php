<div class="space-y-2">
    @if (\Route::currentRouteName() === 'tenaga-pengajar.laporan.edit')
        <h3 class="text-2xl font-semibold" id="penilaian-mahasiswa">Penilaian Mahasiswa</h3>

        <div class="mb-4 flex items-center justify-end">
            <a href="{{ route('tenaga-pengajar.kelas.tambah-mahasiswa', $laporan->classRoom->id) }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Tambah Mahasiswa</x-button>
            </a>
        </div>

        <div class="space-y-4 rounded-md border border-l-8 border-zinc-300 border-l-red-500 p-2">
            <p class="text-sm">
                Anda dapat melakukan export template penilaian untuk mendownload file excel yang berisikan nilai nilai
                mahasiswa. Setelah mengisi template tersebut, Anda dapat mengimportnya kembali ke sistem. Dan sistem
                akan mengolah data tersebut untuk menampilkan komponen nilai mahasiswa secara otomatis.
                <span class="block font-semibold">
                    Catatan: Jika Anda mengimport template penilaian, data yang sudah ada akan dihapus dan digantikan
                </span>
            </p>
            <div class="">
                <a href="{{ route('tenaga-pengajar.laporan.exportPenilaian', $laporan) }}">
                    <x-button.index variant="outline" @click="">Export template penilaian</x-button.index>
                </a>
                <form
                    action="{{ route('tenaga-pengajar.laporan.importPenilaian', $laporan) }}"
                    method="post"
                    enctype="multipart/form-data"
                    class="inline"
                    x-ref="importForm"
                >
                    @csrf
                    @method('PUT')
                    <input
                        x-on:change="$refs.importForm.submit()"
                        type="file"
                        name="file"
                        id="file"
                        class="hidden"
                        x-ref="importInput"
                        accept=".xlsx,.xls"
                    />
                </form>
                <x-button.index x-on:click="$refs.importInput.click()">Import template penilaian</x-button.index>
            </div>
        </div>
    @endif

    <livewire:table.student-grade-table :$laporan />
</div>
