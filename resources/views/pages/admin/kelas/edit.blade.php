<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Edit Kelas
        </span>
        <x-form class="mx-auto max-w-md" method="POST" action="{{ route('admin.kelas.update', $kelas) }}">
            @csrf

            @method("PUT")

            <x-form.item name="academic_year_id">
                <x-form.label>Tahun Akademik</x-form.label>
                <x-select class="" name="academic_year_id">
                    <option value="-" selected disabled>Pilih Tahun Ajaran</option>
                    @forelse ($allAcademicYears as $academicYear)
                        <option
                            value="{{ $academicYear->id }}"
                            {{ $academicYear->id == $kelas->academic_year_id ? "selected" : "" }}
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
                    <option value="-" selected disabled>Pilih Mata Kuliah</option>
                    @forelse (\App\Models\Course::all() as $course)
                        <option value="{{ $course->id }}" {{ $course->id == $kelas->course_id ? "selected" : "" }}>
                            {{ $course->code }} {{ $course->name }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada mata kuliah</option>
                    @endforelse
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item name="lecturer_id">
                <x-form.label>Nama Tenaga Pengajar</x-form.label>
                <x-select class="" name="lecturer_id">
                    <option value="-" selected disabled>Pilih Tenaga Pengajar</option>
                    @forelse ($allLecturers as $lecturer)
                        <option
                            value="{{ $lecturer->id }}"
                            {{ $lecturer->id == $kelas?->lecturer?->id ? "selected" : "" }}
                        >
                            {{ $lecturer->user->name }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada tenaga pengajar</option>
                    @endforelse
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item name="name">
                <x-form.label>Nama Kelas</x-form.label>
                <x-input x-form:control required name="name" placeholder="RA" :value="old('name', $kelas->name)" />
                <x-form.message />
            </x-form.item>

            <x-form.item name="mode">
                <x-form.label>Mode Kuliah</x-form.label>
                <x-input
                    x-form:control
                    required
                    name="mode"
                    placeholder="offline"
                    :value="old('mode', $kelas->mode)"
                />
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
