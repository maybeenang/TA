@php
    $currentStep = $this->getCurrentStep();
@endphp

<div class="space-y-8">
    @foreach ($currentStep->fields() as $field)
        <x-fields.text-area :label="$field->label" :name="$field->name" />
    @endforeach

    <section x-data="{ createDialog: false }">

        <div class="flex justify-between items-center">

            <h3 class="font-semibold">
                Metode Evaluasi
            </h3>

            <x-button.index @click="createDialog = true">
                Tambah Metode Evaluasi
            </x-button.index>
        </div>

        <div class="mt-4">
            <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50 pb-8">
                <thead class="uppercase">
                    <tr>
                        <th class="px-2 py-2 border border-zinc-100 ">Kode CPMK</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Deskripsi CPMK</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Kriteria Bentuk</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Rata Rata NIlai</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 5; $i++)
                        <tr class="odd:bg-zinc-50 even:bg-white align-top">
                            <td class="px-2 py-2 border border-zinc-100">
                                CPMK - {{ $i }}
                            </td>
                            <td class="px-2 py-2 border border-zinc-100 text-wrap">Lorem ipsum dolor sit amet
                                consectetur,
                                adipisicing elit. Possimus labore perferendis nostrum dolores saepe ea consequatur
                                optio, minima maiores illo explicabo eum accusantium! Et, fugit laborum porro ipsa
                                quaerat optio.</td>
                            <td class="px-2 py-2 border border-zinc-100">Kriteria Bentuk-{{ $i }}</td>
                            <td class="px-2 py-2 border border-zinc-100">Rata Rata Nilai-{{ $i }}</td>
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
