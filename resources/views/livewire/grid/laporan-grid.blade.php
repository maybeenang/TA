<div class="w-full space-y-8">
    <x-form class="mx-auto max-w-sm" wire:submit="filterWithAcademicYear">
        <x-form.item>
            <x-form.label>Tahun Akademik</x-form.label>
            <x-select class="" name="academic_year_id" wire:model="academicYearId">
                <option value="-" selected disabled>Pilih Tahun Ajaran</option>
                @forelse ($allAcademicYears as $academicYear)
                    <option
                        value="{{ $academicYear->id }}"
                        @if ($currentAcademicYear->id == $academicYear->id) selected @endif
                    >
                        {{ $academicYear->fullName }}
                    </option>
                @empty
                    <option value="" disabled>Tidak ada tahun ajaran</option>
                @endforelse
            </x-select>
            <x-form.message />
            <div class="flex justify-end">
                <x-button type="submit">Cari</x-button>
            </div>
        </x-form.item>
    </x-form>

    <section class="flex justify-between">
        <div class="flex items-center gap-2">
            <x-label htmlFor="tahun-ajaran">Search</x-label>
            <x-input wire:model.live.debounce.500ms="search" />
        </div>
    </section>

    <section class="grid grid-cols-2 gap-2 md:grid-cols-4">
        @forelse ($this->data() as $item)
            <x-card.laporan-card :value="$item" :role="$role" />
        @empty
            <div class="col-span-2 md:col-span-4">
                <x-card.empty-card />
            </div>
        @endforelse
    </section>
</div>
