@props(['value'])
<div class="flex justify-center">
    <x-dropdown-menu>
        <x-dropdown-menu.trigger class="rounded-sm bg-white p-2 hover:bg-zinc-100">
            <x-icons.v-three-dots-icon />
        </x-dropdown-menu.trigger>
        <x-dropdown-menu.content>
            <x-dropdown-menu.item
                @click="window.location.href = '{{ route($this->routeName . '.show', $value) }}'">Detail</x-dropdown-menu.item>
            <x-dropdown-menu.item
                @click="window.location.href = '{{ route($this->routeName . '.edit', $value) }}'">Edit</x-dropdown-menu.item>
            <x-dropdown-menu.item>Delete</x-dropdown-menu.item>
        </x-dropdown-menu.content>
    </x-dropdown-menu>
</div>
