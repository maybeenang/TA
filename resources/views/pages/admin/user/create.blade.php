<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Tambah Pengguna
        </span>
        <x-form class="mx-auto max-w-md" action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            <x-form.item name="name">
                <x-form.label>Nama</x-form.label>
                <x-input x-form:control required placeholder="John Doe" name="name" :value="old('name')" />
                <x-form.message />
            </x-form.item>

            <x-form.item name="nip">
                <x-form.label>NIP</x-form.label>
                <x-input x-form:control placeholder="1234567890" name="nip" :value="old('nip')" />
                <x-form.message />
            </x-form.item>

            <x-form.item name="email">
                <x-form.label>Email</x-form.label>
                <x-input
                    type="email"
                    x-form:control
                    required
                    placeholder="johndoe@email.com"
                    name="email"
                    :value="old('email')"
                />
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

            <x-form.item class="flex flex-col space-y-4 rounded-md border p-4" name="roles[]">
                <div class="flex-1 space-y-1">
                    <p class="text-sm font-medium leading-none">Role</p>
                    <p class="text-sm text-muted-foreground">Pilih role yang sesuai dengan pengguna yang anda buat</p>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($roles as $value => $role)
                        <div class="flex items-center space-x-2">
                            <x-checkbox
                                id="{{ $value }}"
                                x-form:control
                                name="roles[]"
                                value="{{ $value }}"
                                :checked="in_array($value, old('roles', []))"
                            />
                            <x-label htmlFor="{{ $value }}" class="whitespace-nowrap">{{ $role }}</x-label>
                        </div>
                    @endforeach
                </div>
                <x-form.message />
            </x-form.item>

            <x-button type="submit">Submit</x-button>
        </x-form>
    </div>
</x-app-layout>
