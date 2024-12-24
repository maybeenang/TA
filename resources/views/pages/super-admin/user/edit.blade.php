<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Edit User</span>
        <x-form class="mx-auto max-w-md" action="{{ route('super-admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.item name="name">
                <x-form.label>Nama</x-form.label>
                <x-input
                    x-form:control
                    required
                    placeholder="John Doe"
                    name="name"
                    :value="old('name', $user->name)"
                />
                <x-form.message />
            </x-form.item>

            <x-form.item name="nip">
                <x-form.label>NIP</x-form.label>
                <x-input
                    x-form:control
                    placeholder="1234567890"
                    name="nip"
                    type="number"
                    :value="old('nip', $user->lecturer->nip)"
                />
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
                    :value="old('email', $user->email)"
                />
                <x-form.message />
            </x-form.item>

            <x-form.item name="programStudi">
                <x-form.label>Program Studi</x-form.label>
                <x-select class="" id="programStudi" name="programStudi">
                    <option disabled selected value="-">Pilih Program Studi</option>
                    @foreach ($programStudis as $key => $value)
                        <option
                            value="{{ $key }}"
                            {{ $key === old('programStudi', $user->programStudi?->id) ? 'selected' : '' }}
                        >
                            {{ $value }}
                        </option>
                    @endforeach
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item class="flex flex-col space-y-4 rounded-md border p-4" name="roles[]">
                <div class="flex-1 space-y-1">
                    <p class="text-sm font-medium leading-none">Role</p>
                    <p class="text-sm text-muted-foreground">Pilih role yang sesuai dengan pengguna yang anda buat</p>
                </div>
                <div class="space-y-2">
                    @foreach ($roles as $key => $role)
                        <div class="flex items-center gap-2">
                            <x-checkbox
                                id="{{ $key }}"
                                name="roles[]"
                                value="{{ $key }}"
                                :checked="in_array($key, old('roles', $user->roles->pluck('name')->toArray()))"
                            />
                            <x-label htmlFor="{{ $key }}" class="whitespace-nowrap">
                                {{ $role }}
                            </x-label>
                        </div>
                    @endforeach
                </div>
                <x-form.message />
            </x-form.item>

            <x-form.item name="password">
                <div class="space-y-1 rounded border border-red-500 bg-red-50 p-2">
                    <p class="text-sm text-red-500">Kosongkan password jika tidak ingin mengubah password</p>
                </div>
                <x-form.label>Password</x-form.label>
                <x-input type="password" x-form:control name="password" />
                <x-form.message />
            </x-form.item>
            <x-form.item name="password_confirmation">
                <x-form.label>Konfirmasi Password</x-form.label>
                <x-input type="password" x-form:control name="password_confirmation" />
                <x-form.message />
            </x-form.item>

            <x-button type="submit">Submit</x-button>
        </x-form>
    </div>
</x-app-layout>
