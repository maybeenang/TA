<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Tambah Kelas</span>
        <x-form class="mx-auto max-w-md" method="POST" action="{{ route('super-admin.kelas.update', $classRoom) }}">
            @csrf
            @method('PUT')

            <x-form.item name="academic_year_id">
                <x-form.label>Tahun Akademik</x-form.label>
                <x-select class="" name="academic_year_id">
                    <option value="-" disabled>Pilih Tahun Ajaran</option>
                    @forelse ($academicYears as $academicYear)
                        <option
                            value="{{ $academicYear->id }}"
                            {{ old('academic_year_id', $classRoom->academic_year_id) == $academicYear->id ? 'selected' : '' }}
                        >
                            {{ $academicYear->fullName }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada tahun ajaran</option>
                    @endforelse
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item name="course_id">
                <x-form.label>Mata Kuliah</x-form.label>
                <x-select class="" name="course_id">
                    <option value="-" disabled>Pilih Mata Kuliah</option>
                    @forelse ($courses as $course)
                        <option
                            value="{{ $course->id }}"
                            {{ old('course_id', $classRoom->course_id) == $course->id ? 'selected' : '' }}
                        >
                            {{ $course->fullName }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada mata kuliah</option>
                    @endforelse
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item name="name">
                <x-form.label>Nama Kelas</x-form.label>
                <x-input x-form:control required name="name" placeholder="RA" :value="old('name', $classRoom->name)" />
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
