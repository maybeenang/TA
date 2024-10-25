<div class="">
    <x-form class="max-w-sm mx-auto" wire:submit="filterWithAcademicYear">
        <x-form.item name="academic_year_id">
            <x-form.label>Tahun Akademik</x-form.label>
            <x-select class="" name="academic_year_id" wire:model="academicYearId">
                <option value="-" selected disabled>
                    Pilih Tahun Ajaran
                </option>
                @forelse ($this->getAllAcademicYears() as $academicYear)
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
            <div class="flex justify-end">
                <x-button type="submit">Cari</x-button>
            </div>
        </x-form.item>
    </x-form>
</div>
