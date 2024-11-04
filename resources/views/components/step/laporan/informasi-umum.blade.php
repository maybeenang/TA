<div class="min-h-2 space-y-2">
    <h3 class="text-lg font-semibold" id="informasi-umum-kelas">Informasi Umum Kelas</h3>
    <x-fields.text :value="$laporan->classroom->name" name="classroom_name" label="Nama Kelas" disabled />
    <x-fields.text :value="$laporan->classroom->course->name" name="course_name" label="Nama Mata Kuliah" disabled />
    <x-fields.text :value="$laporan->classroom->course->code" name="course_code" label="Kode MK" disabled />
    <x-fields.text :value="$laporan->classroom->course->credit" name="course_credit" label="SKS" disabled />
    <x-fields.text :value="$laporan->classroom->course->grade" name="course_grade" label="Semester" disabled />

    <x-fields.text
        :value="$laporan->classroom->academicYear->name"
        name="academicyear_name"
        label="Tahun Ajaran"
        disabled
    />

    <x-fields.select
        name="responsible_lecturer"
        label="Dosen Penanggung Jawab"
        :options="$lecturers"
        placeholder="Pilih Dosen Penanggung Jawab"
    />
</div>
