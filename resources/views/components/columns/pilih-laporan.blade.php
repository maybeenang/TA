@props([
    'value',
])

<div class="">
    <x-dropdown-menu>
        <x-dropdown-menu.trigger class="rounded-sm bg-white p-2 hover:bg-zinc-100">
            <x-icons.v-three-dots-icon />
        </x-dropdown-menu.trigger>
        <x-dropdown-menu.content class="whitespace-nowrap">
            <a href="{{ route('tenaga-pengajar.laporan.edit', $value) }}">
                <x-dropdown-menu.item>Edit</x-dropdown-menu.item>
            </a>
            <x-dropdown-menu.item x-on:click="$dispatch('open-confirm-laporan-verifikasi', {{$value->id}})">
                Ajukan Verifikasi
            </x-dropdown-menu.item>
        </x-dropdown-menu.content>
    </x-dropdown-menu>
</div>
