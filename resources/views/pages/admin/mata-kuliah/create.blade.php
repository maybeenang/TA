<x-app-layout>
    <x-alert.flash />
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.person-icon />
            Tambah Mata Kuliah
        </span>
        <x-form class="max-w-md mx-auto" action="{{ route('admin.mata-kuliah.store') }}" method="POST">
            @csrf

            <x-form.item name="name">
                <x-form.label>Nama Mata Kuliah</x-form.label>
                <x-input x-form:control required placeholder="Algoritma Pemrograman" name="name" :value="old('name')" />
                <x-form.message />
            </x-form.item>
            <x-form.item name="credit">
                <x-form.label>Total SKS</x-form.label>
                <x-input x-form:control required placeholder="2" name="credit" :value="old('credit')" />
                <x-form.message />
            </x-form.item>
            <x-button type="submit">Submit</x-button>
        </x-form>
    </div>
</x-app-layout>
