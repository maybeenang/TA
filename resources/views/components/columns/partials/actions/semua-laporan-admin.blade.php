@props([
    "value",
])

<div class="flex justify-center whitespace-nowrap">
    <x-dropdown-menu>
        <x-dropdown-menu.trigger class="rounded-sm bg-white p-2 hover:bg-zinc-100">
            <x-icons.v-three-dots-icon />
        </x-dropdown-menu.trigger>
        <x-dropdown-menu.content>
            <a wire:navigate href="{{ route("admin.laporan.show", $value) }}">
                <x-dropdown-menu.item @click="">Detail</x-dropdown-menu.item>
            </a>

            @if ($value->isEditable)
                <a wire:navigate href="{{ route("admin.laporan.edit", $value) }}">
                    <x-dropdown-menu.item @click="">Edit</x-dropdown-menu.item>
                </a>
            @endif

            <x-dropdown-menu.item @click="$dispatch('open-ubah-status-laporan', {reportId: {{$value->id}}})">
                Ubah Status
            </x-dropdown-menu.item>
            <x-dropdown-menu.item @click="">Berikan Notifikasi Pengingat</x-dropdown-menu.item>
        </x-dropdown-menu.content>
    </x-dropdown-menu>
</div>
