<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Tambah Mata Kuliah</span>
        <x-form class="mx-auto max-w-md" method="POST" action="{{ route('super-admin.mata-kuliah.store') }}">
            @csrf

            <x-form.item name="program_studi_id">
                <x-form.label>Program Studi</x-form.label>
                <x-select x-form:control required name="program_studi_id">
                    <option value="" disabled>Pilih Program Studi</option>
                    @foreach ($programStudis as $id => $name)
                        <option value="{{ $id }}" {{ old('program_studi_id') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item name="name">
                <x-form.label>Nama Mata Kuliah</x-form.label>
                <x-input
                    x-form:control
                    required
                    placeholder="Algoritma Pemrograman"
                    name="name"
                    :value="old('name')"
                />
                <x-form.message />
            </x-form.item>

            <x-form.item name="code">
                <x-form.label>Kode Mata Kuliah</x-form.label>
                <x-input x-form:control required placeholder="IF23332" name="code" :value="old('code')" />
                <x-form.message />
            </x-form.item>

            <x-form.item name="credit">
                <x-form.label>Jumlah SKS</x-form.label>
                <x-input x-form:control required placeholder="2" name="credit" :value="old('credit')" />
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
