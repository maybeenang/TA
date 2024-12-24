<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Tambah Mahasiswa</span>
        <x-form class="mx-auto max-w-md" method="POST" action="{{ route('super-admin.student.store') }}">
            @csrf

            <x-form.item name="name">
                <x-form.label>Nama Mahasiswa</x-form.label>
                <x-input x-form:control required name="name" placeholder="John Doe" :value="old('name')" />
                <x-form.message />
            </x-form.item>

            <x-form.item name="nim">
                <x-form.label>NIM</x-form.label>
                <x-input
                    x-form:control
                    required
                    name="nim"
                    type="number"
                    placeholder="123123123"
                    :value="old('nim')"
                />
                <x-form.message />
            </x-form.item>

            <x-form.item name="programStudi">
                <x-form.label>Program Studi</x-form.label>
                <x-select class="" id="programStudi" name="programStudi">
                    <option disabled selected value="-">Pilih Program Studi</option>
                    @foreach ($programStudis as $key => $value)
                        <option value="{{ $key }}">
                            {{ $value }}
                        </option>
                    @endforeach
                </x-select>
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
