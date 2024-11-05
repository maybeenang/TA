<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Edit CPMK
        </span>

        <x-form class="mx-auto max-w-md" method="POST" action="{{ route('admin.kelas.store') }}">
            @csrf

            <x-form.item name="code">
                <x-form.label>Kode CPMK</x-form.label>
                <x-input x-form:control required name="name" placeholder="RA, RB" :value="old('name')" />
                <x-form.message />
            </x-form.item>

            <x-form.item name="code">
                <x-form.label>Kode CPMK</x-form.label>
                <x-input x-form:control required name="name" placeholder="RA, RB" :value="old('name')" />
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
