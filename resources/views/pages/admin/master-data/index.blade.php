<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Pengaturan</span>

        <div class="my-8 max-w-xl">
            <h2 class="mb-4 text-lg font-semibold">Edit Program Studi</h2>
            <form class="space-y-4 px-6" action="{{ route('admin.master-data.program-studi.update') }}" method="POST">
                @csrf
                @method('put')
                <div>
                    <x-input-label for="program_studi" value="Nama Program Studi" />
                    <x-input
                        id="program_studi"
                        name="program_studi"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Nama Program Studi"
                        value="{{ $programStudi->name }}"
                        required
                        autofocus
                    />
                </div>
                <div>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </div>

        <div class="mb-8 max-w-fit">
            <h2 class="mb-4 text-lg font-semibold">Kelola Data Akademik {{ $programStudi->name }}</h2>
            <x-alert>
                <x-alert.title>Catatan</x-alert.title>
                <x-alert.description>
                    Berikut adalah penjelasan terkait fitur untuk kelola data akademik.
                    <ul class="list-disc pl-4">
                        <li>Export: Mengunduh data akademik dalam format Excel.</li>
                        <li>Import: Mengunggah data akademik dari file Excel.</li>
                        <li>
                            Sinkron: Menyinkronkan data akademik dengan sistem lain.
                            <ul class="list-disc pl-4">
                                <li>
                                    Tahun akademik: akan mencoba untuk mengambil data, lalu menambahkan dan atau
                                    mengupdate tahun akademik
                                </li>
                                <li>
                                    Pengguna: akan mencoba untuk mengambil data, lalu menambahkan dan atau mengupdate
                                    pengguna, dengan default role tenaga pengajar
                                </li>
                                <li>
                                    Kelas: akan mencoba untuk mengambil data, lalu menambahkan dan atau mengupdate mata
                                    kuliah dan kelas (untuk tahun akademik yang aktif)
                                </li>
                                <li>Mahasiswa: akan mencoba mengambil mahasiswa yang sudah terdaftar di kelas.</li>
                            </ul>
                        </li>
                    </ul>
                </x-alert.description>
            </x-alert>
            <div class="space-y-4">
                <table class="table table-auto divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                Terakhir Di Import
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                Terakhir Berhasil Sinkronasi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($settings as $item)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $item->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $item->last_updated_at ?? 'Belum ada data' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $item->last_synced_at ?? 'Belum ada data' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.master-data.export', $item->key) }}">
                                            <x-button>Export</x-button>
                                        </a>
                                        <form
                                            action="{{ route('admin.master-data.import', $item->key) }}"
                                            method="post"
                                            x-ref="form"
                                            x-data
                                            enctype="multipart/form-data"
                                        >
                                            @csrf

                                            <input
                                                type="file"
                                                name="file"
                                                id="file"
                                                accept=".xlsx, .xls"
                                                class="hidden"
                                                x-ref="file"
                                                x-on:change="
                                                    if ($event.target.files.length > 0) {
                                                        $refs.form.submit()
                                                    }
                                                "
                                            />

                                            <x-button x-on:click="$refs.file.click()">Import</x-button>
                                        </form>
                                        <form action="{{ route('admin.master-data.sync', $item->key) }}" method="post">
                                            @csrf
                                            <x-button type="submit">Sync</x-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
