<div class="min-h-2 space-y-2" x-data="{ createDialog: false }">
    <h3 class="text-lg font-semibold" id="metode-evaluasi">Metode Evaluasi</h3>

    <x-button.index @click="createDialog = true">Tambah Metode Evaluasi</x-button.index>

    <div class="overflow-auto">
        <table class="w-full table-auto border-collapse whitespace-nowrap border border-zinc-50 pb-8 text-left">
            <thead class="uppercase">
                <tr>
                    <th class="border border-zinc-100 px-2 py-2">Kode CPMK</th>
                    <th class="w-[500px] border border-zinc-100 px-2 py-2">Deskripsi CPMK</th>
                    <th class="border border-zinc-100 px-2 py-2">Kriteria Bentuk</th>
                    <th class="border border-zinc-100 px-2 py-2">Rata Rata NIlai</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 5; $i++)
                    <tr class="align-top odd:bg-zinc-50 even:bg-white">
                        <td class="border border-zinc-100 px-2 py-2">CPMK - {{ $i }}</td>
                        <td class="text-wrap border border-zinc-100 px-2 py-2">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Possimus labore perferendis
                            nostrum dolores saepe ea consequatur optio, minima maiores illo explicabo eum accusantium!
                            Et, fugit laborum porro ipsa quaerat optio.
                        </td>
                        <td class="border border-zinc-100 px-2 py-2">Kriteria Bentuk-{{ $i }}</td>
                        <td class="border border-zinc-100 px-2 py-2">Rata Rata Nilai-{{ $i }}</td>
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
</div>
