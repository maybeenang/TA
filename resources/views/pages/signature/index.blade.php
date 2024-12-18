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
            <a href="{{ route('signature.create') }}">
                <x-button class="bg-blue-500 hover:bg-blue-600">Tambah tanda tangan</x-button>
            </a>
        </div>

        <section class="grid grid-cols-2 gap-2 md:grid-cols-4">
            @forelse ($signatures as $item)
                <x-card.signature-card :value="$item" />
            @empty
                <div class="col-span-2 md:col-span-4">
                    <x-card.empty-card />
                </div>
            @endforelse
        </section>
    </div>
</x-app-layout>
