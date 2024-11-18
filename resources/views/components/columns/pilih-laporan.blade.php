@props([
    "value",
])

<div class="">
    <x-dropdown-menu>
        <x-dropdown-menu.trigger class="rounded-sm bg-white p-2 hover:bg-zinc-100">
            <x-icons.v-three-dots-icon />
        </x-dropdown-menu.trigger>
        <x-dropdown-menu.content>
            <a href="{{ route("tenaga-pengajar.laporan.edit", $value) }}" wire:navigate.hover x-ref="editLink">
                <x-dropdown-menu.item>Edit</x-dropdown-menu.item>
            </a>
            <a href="{{ route("tenaga-pengajar.laporan.show", $value) }}" wire:navigate.hover x-ref="editLink">
                <x-dropdown-menu.item>Detail</x-dropdown-menu.item>
            </a>
        </x-dropdown-menu.content>
    </x-dropdown-menu>
</div>
