@php
    $currentStep = $this->getCurrentStep();
@endphp

<div class="">

    <section x-data="{ createDialog: false }">

        <div class="flex justify-between items-center">

            <h3 class="font-semibold">Penilaian Mahasiswa</h3>

        </div>

        <div class="mt-2">
            <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50 pb-8">
                <thead class="uppercase">
                    <tr>
                        <th class="px-2 py-2 border border-zinc-100 ">Penilaian</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 7; $i++)
                        <tr class="odd:bg-zinc-50 even:bg-white align-top">
                            <td class="px-2 py-2 border border-zinc-100">Rata Rata Nilai-{{ $i }}</td>
                            <td class="px-2 py-2 border border-zinc-100">Kriteria Bentuk-{{ $i }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50 pb-8">
                <thead class="uppercase">
                    <tr>
                        <th class="px-2 py-2 border border-zinc-100 ">Konversi Nilai</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Rentang Nilai</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Kualifikasi Angka Mutu</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 7; $i++)
                        <tr class="odd:bg-zinc-50 even:bg-white align-top">
                            <td class="px-2 py-2 border border-zinc-100">A</td>
                            <td class="px-2 py-2 border border-zinc-100">NA => 75</td>
                            <td class="px-2 py-2 border border-zinc-100">4</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50 pb-8">
                <thead class="uppercase">
                    <tr>
                        <th class="px-2 py-2 border border-zinc-100 ">No</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Nim</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Nama</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Nilai</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Total Nilai</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Praktikum</th>
                        <th class="px-2 py-2 border border-zinc-100 ">RBL</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Kehadiran</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Kuis</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Tugas</th>
                        <th class="px-2 py-2 border border-zinc-100 ">UTS</th>
                        <th class="px-2 py-2 border border-zinc-100 ">UAS</th>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 50; $i++)
                        <tr class="odd:bg-zinc-50 even:bg-white align-top">
                            <td class="px-2 py-2 border border-zinc-100">{{ $i }}</td>
                            <td class="px-2 py-2 border border-zinc-100">123456</td>
                            <td class="px-2 py-2 border border-zinc-100">John Doe</td>
                            <td class="px-2 py-2 border border-zinc-100">A</td>
                            <td class="px-2 py-2 border border-zinc-100">80</td>
                            <td class="px-2 py-2 border border-zinc-100">80</td>
                            <td class="px-2 py-2 border border-zinc-100">80</td>
                            <td class="px-2 py-2 border border-zinc-100">80</td>
                            <td class="px-2 py-2 border border-zinc-100">80</td>
                            <td class="px-2 py-2 border border-zinc-100">80</td>
                            <td class="px-2 py-2 border border-zinc-100">80</td>
                            <td class="px-2 py-2 border border-zinc-100">80</td>
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
