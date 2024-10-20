<x-app-layout>
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.person-icon />
            Tambah Tenaga Pengajar
        </span>
        <x-form class="max-w-md mx-auto">
            <x-form.item>
                <x-form.label>Nama</x-form.label>
                <x-input x-form:control placeholder="John Doe" />
                <x-form.message />
            </x-form.item>
            <x-form.item>
                <x-form.label>NIP</x-form.label>
                <x-input x-form:control placeholder="123123123123" />
                <x-form.message />
            </x-form.item>
            <x-form.item>
                <x-form.label>Email</x-form.label>
                <x-input x-form:control placeholder="johndoe@email.com" />
                <x-form.message />
            </x-form.item>
            <x-form.item>
                <x-form.label>Password</x-form.label>
                <x-input x-form:control />
                <x-form.message />
            </x-form.item>
            <x-button type="submit">Submit</x-button>
        </x-form>
    </div>
</x-app-layout>
