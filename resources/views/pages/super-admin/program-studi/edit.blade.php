<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Edit Program Studi</span>
        <x-form
            class="mx-auto max-w-md"
            method="POST"
            action="{{ route('super-admin.program-studi.update', $programStudi->id) }}"
        >
            @csrf
            @method('PUT')

            <x-form.item name="name">
                <x-form.label>Nama Program Studi</x-form.label>
                <x-input
                    x-form:control
                    required
                    name="name"
                    placeholder="Teknik Informatika"
                    :value="old('name', $programStudi->name)"
                />
                <x-form.message />
            </x-form.item>

            <x-form.item name="fakultas">
                <x-form.label>Fakultas</x-form.label>
                <x-select class="" id="fakultas" name="fakultas">
                    <option disabled value="-">Pilih Fakultas</option>
                    @foreach ($fakultas as $key => $value)
                        <option
                            value="{{ $key }}"
                            {{ $key === old('fakultas', $programStudi->fakultas?->id) ? 'selected' : '' }}
                        >
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
