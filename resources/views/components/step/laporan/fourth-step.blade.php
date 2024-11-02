@php
    $currentStep = $this->getCurrentStep();
@endphp

<div class="">

    <section x-data="{ createDialog: false }">

        <div class="flex justify-between items-center">

            <h3 class="font-semibold">Presensi dan Keaktifan Mahasiswa</h3>

        </div>

        <div class="mt-2">
            <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50 pb-8">
                <thead class="uppercase">
                    <tr>
                        <th class="px-2 py-2 border border-zinc-100 ">Pertemuan (minggu)</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Peserta Hadir</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Peserta yang aktif diskusi</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 17; $i++)
                        <tr class="odd:bg-zinc-50 even:bg-white align-top">
                            <td class="px-2 py-2 border border-zinc-100">Kriteria Bentuk-{{ $i }}</td>
                            <td class="px-2 py-2 border border-zinc-100">Rata Rata Nilai-{{ $i }}</td>
                            <td class="px-2 py-2 border border-zinc-100">Kriteria Bentuk-{{ $i }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

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
    </section>

</div>
