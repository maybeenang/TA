<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Tambah Mata Kuliah
        </span>
        <x-form class="mx-auto max-w-md" action="{{ route('admin.mata-kuliah.store') }}" method="POST">
            @csrf

            <x-form.item name="code">
                <x-form.label>Kode Mata Kuliah</x-form.label>
                <x-input x-form:control required placeholder="IF2222" name="code" :value="old('code')" />
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
            <x-form.item name="credit">
                <x-form.label>Jumlah SKS</x-form.label>
                <x-input x-form:control required placeholder="2" name="credit" :value="old('credit')" />
                <x-form.message />
            </x-form.item>
            <x-button type="submit">Submit</x-button>
        </x-form>
    </div>
</x-app-layout>
