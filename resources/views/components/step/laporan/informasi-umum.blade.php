<form class="min-h-2 space-y-2" action="{{ route("tenaga-pengajar.laporan.update", $laporan) }}" method="post">
    @csrf
    @method("PUT")

    @if ($errors->any())
        <x-alert variant="destructive" class="my-4 rounded-sm">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <input type="hidden" name="step" value="informasi-umum" />
    <h3 class="text-2xl font-semibold" id="informasi-umum">Informasi Umum Kelas</h3>
    <x-fields.text :value="$laporan->classroom->name" name="" label="Nama Kelas" disabled />
    <x-fields.text :value="$laporan->classroom->course->name" name="" label="Nama Mata Kuliah" disabled />
    <x-fields.text :value="$laporan->classroom->course->code" name="" label="Kode MK" disabled />
    <x-fields.text :value="$laporan->classroom->course->credit" name="" label="SKS" disabled />
    <x-fields.text :value="$laporan->classroom->course->grade" name="" label="Semester" disabled />

    <x-fields.text :value="$laporan->classroom->academicYear->name" name="" label="Tahun Ajaran" disabled />

    <x-fields.select
        name="responsible_lecturer"
        label="Dosen Penanggung Jawab"
        :options="$lecturers"
        placeholder="Pilih Dosen Penanggung Jawab"
        :value="$laporan->responsible_lecturer"
    />

    <x-fields.select-multiple
        name="report_lecturers[]"
        label="Dosen Pengampu"
        :options="$lecturers"
        placeholder="Pilih Dosen Pengampu"
        :value="$laporan->lecturers->pluck('id')->toArray()"
    />

    <div class="flex justify-end">
        <x-button type="submit">Simpan</x-button>
    </div>
</form>
