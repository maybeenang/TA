<x-app-layout>
    <div
        class="border-zinc-100 border p-2 rounded-md border-t-red-500 border-t-4 border-b-yellow-500 border-b-4 space-y-4">
        <span class="text-sm flex items-center gap-1">
            <x-icons.person-icon />
            Edit Informasi Pengguna
        </span>
        <div class="">

            <section class="rounded-md flex items-center justify-center md:justify-start flex-col gap-2 ">
                <div class="h-[300px] w-[300px] md:h-[200px] md:w-[200px] rounded-md bg-zinc-200 mx-auto">

                </div>
                <x-button>Upload Foto</x-button>
            </section>
            <section class="rounded-md max-w-screen-md mx-auto">
                <x-form class="max-w-md mx-auto" action="{{ route('admin.user.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <x-form.item name="name">
                        <x-form.label>Nama</x-form.label>
                        <x-input x-form:control required placeholder="John Doe" name="name" :value="old('name', $user->name)" />
                        <x-form.message />
                    </x-form.item>
                    <x-form.item name="nip">
                        <x-form.label>NIP <span class="text-sm font-normal">(optional)</span></x-form.label>
                        <x-input x-form:control placeholder="1234567890" name="nip" :value="old('nip', $user?->lecturer?->nip)" />
                        <x-form.message />
                    </x-form.item>

                    <x-form.item name="email">
                        <x-form.label>Email</x-form.label>
                        <x-input type="email" x-form:control required placeholder="johndoe@email.com" name="email"
                            :value="old('email', $user->email)" />
                        <x-form.message />
                    </x-form.item>

                    <x-form.item class="flex flex-col space-y-4 rounded-md border p-4">
                        <div class="flex-1 space-y-1">
                            <p class="text-sm font-medium leading-none">Role</p>
                            <p class="text-sm text-muted-foreground">
                                Pilih role yang sesuai dengan pengguna yang anda edit
                            </p>
                        </div>
                        <div class="flex gap-4">

                            @foreach ($roles as $role)
                                <x-form.item class="">
                                    <x-checkbox id="{{ $role->value }}" x-form:control name="roles[]"
                                        value="{{ $role->value }}" :checked="in_array(
                                            $role->value,
                                            old('roles', $user->roles->pluck('name')->toArray()),
                                        )" />
                                    <x-form.label class="whitespace-nowrap">{{ $role->label() }}</x-form.label>
                                </x-form.item>
                            @endforeach

                        </div>
                        <x-form.message />
                    </x-form.item>

                    <x-alert variant="destructive">
                        <x-lucide-triangle-alert class="size-4" />
                        <x-alert.title>Perhatian !</x-alert.title>
                        <x-alert.description>
                            Jika anda tidak ingin mengganti password, silahkan kosongkan field password dan konfirmasi
                            password
                        </x-alert.description>
                    </x-alert>

                    <x-form.item name="password">
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
            </section>
        </div>
    </div>

</x-app-layout>
