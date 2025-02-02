<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            {{ $kelas->course->name }} {{ $kelas->name }}
        </span>
        <section>
            <h1 class="text-center text-xl">{{ $kelas->course->name }}</h1>
        </section>

        <section class="mb-8">
            <table class="w-full border-collapse">
                @foreach ($informasiUmum as $key => $value)
                    <tr class="w-full">
                        <td class="w-44 border border-x-0 border-y-2 border-zinc-200 px-2 py-2 capitalize">
                            {{ $key }}
                        </td>
                        <td class="w-2 border border-x-0 border-y-2 border-zinc-200 px-2 py-2">:</td>
                        <td class="border border-x-0 border-y-2 border-zinc-200 px-2 py-2">
                            <div class="flex gap-1">
                                {{ $value }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </section>

        <section>
            <h1 class="text-center text-xl">Daftar Mahasiswa</h1>

            <div class="mb-4 flex items-center justify-end gap-2">
                <div class="has-tooltip relative" x-data>
                    <x-button class="relative bg-green-500 hover:bg-green-600" x-on:click.prevent="$refs.file.click()">
                        Import Mahasiswa
                    </x-button>

                    <span class="tooltip">
                        <a href="{{ route('export-mhs', $kelas->id) }}" class="text-blue-500 hover:text-blue-600">
                            Unduh template
                        </a>
                    </span>

                    <form
                        action="{{ route('import-mhs', $kelas->id) }}"
                        class="sr-only"
                        method="post"
                        enctype="multipart/form-data"
                        x-ref="form"
                    >
                        @csrf

                        <input
                            type="file"
                            name="file"
                            id="file"
                            accept=".xlsx"
                            class="hidden"
                            x-ref="file"
                            x-on:change="$refs.form.submit()"
                        />
                    </form>
                </div>
                <a href="{{ route('tenaga-pengajar.kelas.tambah-mahasiswa', $kelas->id) }}">
                    <x-button class="bg-blue-500 hover:bg-blue-600">Tambah Mahasiswa</x-button>
                </a>
            </div>

            <x-step.laporan.penilaian-mahasiswa :laporan="$kelas->report" />
        </section>
    </div>
</x-app-layout>
