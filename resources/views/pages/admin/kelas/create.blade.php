<x-app-layout>
    <x-alert.flash />
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.backpack-icon />
            Tambah Kelas
        </span>
        <x-form class="max-w-md mx-auto" method="POST" action="{{ route('admin.kelas.store') }}">
            @csrf

            <x-form.item name="academic_year_id">
                <x-form.label>Tahun Akademik</x-form.label>
                <x-select class="" name="academic_year_id">
                    <option value="-" selected disabled>
                        Pilih Tahun Ajaran
                    </option>
                    @forelse ($academicYears as $academicYear)
                        <option value="{{ $academicYear->id }}">
                            {{ $academicYear->name }}
                        </option>
                    @empty
                        <option value="" disabled>
                            Tidak ada tahun ajaran
                        </option>
                    @endforelse
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item name="course_id">
                <x-form.label>Mata Kuliah</x-form.label>
                <x-select class="" name="course_id">
                    <option value="-" selected disabled>
                        Pilih Mata Kuliah
                    </option>
                    @forelse ($courses as $course)
                        <option value="{{ $course->id }}">
                            {{ $course->code }} {{ $course->name }}
                        </option>
                    @empty
                        <option value="" disabled>
                            Tidak ada mata kuliah
                        </option>
                    @endforelse
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item name="name">
                <x-form.label>Nama Kelas</x-form.label>
                <x-input x-form:control required name="name" placeholder="RA, RB" :value="old('name')" />
                <x-form.description>
                    Untuk membuat lebih dari satu kelas, pisahkan nama kelas dengan tanda koma, <span
                        class="font-semibold">contoh: RA, RB, RC</span>
                </x-form.description>
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>

        </x-form>
    </div>
</x-app-layout>
