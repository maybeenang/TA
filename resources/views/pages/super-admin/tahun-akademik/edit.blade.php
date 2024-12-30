<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Edit Tahun Akdemik</span>

        <x-form
            class="mx-auto max-w-md"
            method="POST"
            action="{{ route('super-admin.tahun-akademik.update', $academicYear) }}"
        >
            @csrf
            @method('PUT')

            <x-form.item name="name">
                <x-form.label>Nama Tahun Akademik</x-form.label>
                <x-input
                    x-form:control
                    required
                    name="name"
                    placeholder="2024/2025"
                    :value="old('name', $academicYear->name)"
                />
                <x-form.message />
            </x-form.item>

            <x-form.item name="name">
                <x-form.label>Semester</x-form.label>
                <x-input
                    x-form:control
                    required
                    name="semester"
                    placeholder="Ganjil"
                    :value="old('semester', $academicYear->semester)"
                />
                <x-form.message />
            </x-form.item>

            <x-form.item name="start_date">
                <x-form.label>Tanggal Mulai</x-form.label>
                <x-input
                    x-form:control
                    required
                    name="start_date"
                    type="date"
                    :value="old('start_date', $academicYear->start_date)"
                    x-on:click="
                        $el.showPicker()
                    "
                />
                <x-form.message />
            </x-form.item>

            <x-form.item name="end_date">
                <x-form.label>Tanggal Selesai</x-form.label>
                <x-input
                    x-form:control
                    required
                    name="end_date"
                    type="date"
                    :value="old('end_date', $academicYear->end_date)"
                    x-on:click="
                        $el.showPicker()
                    "
                />
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
