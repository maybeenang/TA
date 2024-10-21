<x-app-layout>
    <x-alert.flash />
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.person-icon />
            Tambah Tahun Akdemik
        </span>
        <x-form class="max-w-md mx-auto" method="POST" action="{{ route('admin.tahun-akademik.store') }}">
            @csrf

            <x-form.item name="name">
                <x-form.label>Nama Tahun Akademik</x-form.label>
                <x-input x-form:control required name="name" placeholder="2024/2025 Ganjil" :value="old('name')" />
                <x-form.message />
            </x-form.item>

            <x-form.item name="start_date">
                <x-form.label>Tanggal Mulai</x-form.label>
                <x-input x-form:control required name="start_date" type="date" :value="old('start_date')"
                    x-on:click="
                        $el.showPicker()
                    " />
                <x-form.message />
            </x-form.item>

            <x-form.item name="end_date">
                <x-form.label>Tanggal Selesai</x-form.label>
                <x-input x-form:control required name="end_date" type="date" :value="old('end_date')"
                    x-on:click="
                        $el.showPicker()
                    " />
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>

        </x-form>
    </div>
</x-app-layout>
