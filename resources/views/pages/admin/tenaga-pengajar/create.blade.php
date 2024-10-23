<x-app-layout>
    <x-alert.flash />
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.person-icon />
            Tambah Tenaga Pengajar
        </span>
        <x-form class="max-w-md mx-auto" action="{{ route('admin.tenaga-pengajar.store') }}" method="POST">
            @csrf

            <x-form.item name="name">
                <x-form.label>Nama</x-form.label>
                <x-input x-form:control required placeholder="John Doe" name="name" :value="old('name')" />
                <x-form.message />
            </x-form.item>
            <x-form.item name="nip">
                <x-form.label>NIP</x-form.label>
                <x-input x-form:control required placeholder="1234567890" name="nip" :value="old('nip')" />
                <x-form.message />
            </x-form.item>
            <x-form.item name="email">
                <x-form.label>Email</x-form.label>
                <x-input type="email" x-form:control required placeholder="johndoe@email.com" name="email"
                    :value="old('email')" />
                <x-form.message />
            </x-form.item>
            <x-form.item name="password">
                <x-form.label>Password</x-form.label>
                <x-input type="password" required x-form:control name="password" />
                <x-form.message />
            </x-form.item>
            <x-form.item name="password_confirmation">
                <x-form.label>Konfirmasi Password</x-form.label>
                <x-input type="password" required x-form:control name="password_confirmation" />
                <x-form.message />
            </x-form.item>
            <x-button type="submit">Submit</x-button>
        </x-form>
    </div>
</x-app-layout>
