<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Kelola Tanda Tangan
        </span>

        <div class="flex justify-end">
            <a href="{{ route("admin.signature.create") }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Tambah tanda tangan</x-button>
            </a>
        </div>

        <div class="mx-auto grid grid-cols-4 gap-2">
            @forelse ($signatures as $item)
                <div class="flex w-full flex-col justify-between rounded border border-zinc-300 p-2">
                    <div>
                        <img
                            src="{{ route("admin.signature.show", $item) }}"
                            alt="signature"
                            class="h-full w-full object-cover"
                        />
                    </div>

                    <div class="mt-4 space-y-1">
                        <h1 class="text-xs font-semibold">{{ $item->name }}</h1>
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route("admin.signature.edit", $item) }}">
                                <button class="rounded bg-amber-600 px-3 py-1 text-xs text-white">Edit</button>
                            </a>
                            <form action="{{ route("admin.signature.destroy", $item) }}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="rounded bg-red-600 px-3 py-1 text-xs text-white">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <h1>Tidak ada data</h1>
            @endforelse
        </div>
    </div>
</x-app-layout>
