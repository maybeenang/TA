@props([
    'value',
])

<div class="flex justify-center" x-data="{
    deleteDialog: false,
}">
    <x-dropdown-menu>
        <x-dropdown-menu.trigger class="rounded-sm bg-white p-2 hover:bg-zinc-100">
            <x-icons.v-three-dots-icon />
        </x-dropdown-menu.trigger>
        <x-dropdown-menu.content>
            <x-dropdown-menu.item @click="window.location.href = '{{ route($this->routeName . '.show', $value) }}'">
                Detail
            </x-dropdown-menu.item>
            <x-dropdown-menu.item @click="window.location.href = '{{ route($this->routeName . '.edit', $value) }}'">
                Edit
            </x-dropdown-menu.item>
            <x-dropdown-menu.item @click="deleteDialog = true">Delete</x-dropdown-menu.item>
        </x-dropdown-menu.content>
    </x-dropdown-menu>

    <!--delete dialog-->
    <x-dialog x-model="deleteDialog">
        <x-dialog.content>
            <x-dialog.header>
                <x-dialog.title>Apakah Anda yakin?</x-dialog.title>
                <x-dialog.footer>
                    <x-button variant="secondary" type="submit" @click="deleteDialog = false">Batal</x-button>
                    <form method="post" action="{{ route($this->routeName . '.destroy', $value) }}">
                        @csrf
                        @method('delete')
                        <x-button variant="destructive" type="submit">Hapus</x-button>
                    </form>
                </x-dialog.footer>
            </x-dialog.header>
        </x-dialog.content>
    </x-dialog>
</div>
