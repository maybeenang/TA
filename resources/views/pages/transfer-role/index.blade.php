<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Transfer Role
        </span>

        <x-form class="mx-auto max-w-md" method="POST" action="{{ route('transfer-role.update') }}">
            @csrf
            @method('PUT')

            <x-alert variant="destructive">
                <x-alert.title>Perhatian !</x-alert.title>
                <x-alert.description>
                    Hanya gunakan fitur ini jika anda ingin melakukan transfer role anda ke pengguna lain.
                </x-alert.description>
            </x-alert>

            <x-form.item name="currentRole">
                <x-form.label>Role anda saat ini</x-form.label>
                <x-select class="cursor-pointer" id="currentRole" name="currentRole">
                    <option value="" disabled>Pilih role anda saat ini</option>
                    @foreach ($currentRoles as $role)
                        <option value="{{ $role }}">
                            {{ $role }}
                        </option>
                    @endforeach
                </x-select>
                <x-form.message />
            </x-form.item>

            <x-form.item name="transferTo">
                <x-form.label>Transfer ke</x-form.label>
                <x-select class="cursor-pointer" id="transferTo" name="transferTo">
                    <option value="" disabled selected>Pilih pengguna</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
