@props(['value'])
<div class="flex justify-center items-center">
    <x-dropdown-menu>
        <x-dropdown-menu.trigger
            class="w-[50px] bg-white py-1 border-zinc-200 border rounded-md text-center flex justify-center">
            <x-icons.three-dots-icon />
        </x-dropdown-menu.trigger>
        <x-dropdown-menu.content>
            <x-dropdown-menu.label>Aksi</x-dropdown-menu.label>
            <x-dropdown-menu.separator />
            <x-dropdown-menu.item>Detail</x-dropdown-menu.item>
            <x-dropdown-menu.item>Edit</x-dropdown-menu.item>
            <x-dropdown-menu.item>Hapus</x-dropdown-menu.item>
        </x-dropdown-menu.content>
    </x-dropdown-menu>
</div>
