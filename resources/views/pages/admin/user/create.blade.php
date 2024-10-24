<x-app-layout>
    <x-alert.flash />
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.person-icon />
            Tambah Pengguna
        </span>
        <x-form class="max-w-md mx-auto" action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            <x-form.item name="name">
                <x-form.label>Nama</x-form.label>
                <x-input x-form:control required placeholder="John Doe" name="name" :value="old('name')" />
                <x-form.message />
            </x-form.item>

            <div x-data="{
                tenagaPengajar: {{ old('tenaga_pengajar', 'false') === 'on' ? 'true' : 'false' }}
            }" class="space-y-2">

                <x-form.item class=" flex items-center space-x-4 rounded-md border p-4">
                    <div class="flex-1 space-y-1">
                        <p class="text-sm font-medium leading-none">Tenaga Pengajar</p>
                        <p class="text-sm text-muted-foreground">
                            Apakah pengguna yang anda buat adalah tenaga pengajar?
                        </p>
                    </div>
                    <x-switch x-model="tenagaPengajar" name="tenaga_pengajar" :value="old('tenaga_pengajar')" />
                </x-form.item>

                <x-form.item name="nip" x-show="tenagaPengajar" x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-end="opacity-0 transform scale-95">
                    <x-form.label>NIP</x-form.label>
                    <x-input x-form:control placeholder="1234567890" name="nip" :value="old('nip')" />
                    <x-form.message />
                </x-form.item>

            </div>

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

            <div class="flex flex-col space-y-4 rounded-md border p-4">
                <div class="flex-1 space-y-1">
                    <p class="text-sm font-medium leading-none">Role</p>
                    <p class="text-sm text-muted-foreground">
                        Pilih role yang sesuai dengan pengguna yang anda buat
                    </p>
                </div>
                <div class="grid grid-cols-4">

                    @foreach ($roles as $role)
                        <div class="flex items-center space-x-2">
                            <x-checkbox id="{{ $role->value }}" />
                            <x-label htmlFor="{{ $role->value }}"
                                class="whitespace-nowrap">{{ $role->label() }}</x-label>
                        </div>
                    @endforeach

                </div>
            </div>

            <x-button type="submit">Submit</x-button>
        </x-form>
    </div>
</x-app-layout>
