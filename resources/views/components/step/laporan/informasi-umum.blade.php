<div class="min-h-2 space-y-2">
    <h3 class="text-lg font-semibold" id="informasi-umum">Informasi Umum</h3>
    <x-fields.text :value="$laporan->classroom->name" name="classroom_name" label="Nama Kelas" />
    <x-fields.text :value="$laporan->classroom->course->name" name="course_name" label="Nama Mata Kuliah" />
    <x-fields.text :value="$laporan->classroom->course->code" name="course_code" label="Kode MK" />
    <x-fields.text :value="$laporan->classroom->course->credit" name="course_credit" label="SKS" />
    <x-fields.text :value="$laporan->classroom->course->grade" name="course_grade" label="Semester" />
    <x-fields.text :value="$laporan->classroom->academicYear->name" name="academicyear_name" label="Tahun Ajaran" />
</div>
