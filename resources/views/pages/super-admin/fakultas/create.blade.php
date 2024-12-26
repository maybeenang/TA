<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Tambah Fakultas</span>
        <x-form class="mx-auto max-w-md" method="POST" action="{{ route('super-admin.fakultas.store') }}">
            @csrf

            <x-form.item name="name">
                <x-form.label>Nama Fakultas</x-form.label>
                <x-input
                    x-form:control
                    required
                    name="name"
                    placeholder="Fakultas Teknologi Industri"
                    :value="old('name')"
                />
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
