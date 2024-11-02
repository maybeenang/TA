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
                Kuisioner
            </h3>

            <x-button.index @click="createDialog = true">
                Tambah Metode Evaluasi
            </x-button.index>
        </div>

        <div class="mt-2">
            <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50 pb-8">
                <thead class="uppercase">
                    <tr>
                        <th class="px-2 py-2 border border-zinc-100 ">No</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Komponen Penilaian</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Sangat Setuju</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Setuju</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Tidak Setuju</th>
                        <th class="px-2 py-2 border border-zinc-100 ">Sangat Tidak Setuju</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 5; $i++)
                        <tr class="odd:bg-zinc-50 even:bg-white align-top">
                            <td class="px-2 py-2 border border-zinc-100">
                                {{ $i + 1 }}
                            </td>
                            <td class="px-2 py-2 border border-zinc-100">Kriteria Bentuk-{{ $i }}</td>
                            <td class="px-2 py-2 border border-zinc-100">Rata Rata Nilai-{{ $i }}</td>
                            <td class="px-2 py-2 border border-zinc-100">Kriteria Bentuk-{{ $i }}</td>
                            <td class="px-2 py-2 border border-zinc-100">Kriteria Bentuk-{{ $i }}</td>
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
