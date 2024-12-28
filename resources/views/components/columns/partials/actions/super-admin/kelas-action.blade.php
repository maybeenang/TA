@props([
    'value',
])

<div class="flex items-center justify-end gap-1 text-white">
    <a href="{{ route('super-admin.kelas.scrape-data', $value) }}">
        <button class="rounded bg-blue-500 px-2 py-1 text-xs text-white">Scrape</button>
    </a>

    <a href="{{ route('super-admin.kelas.show', $value) }}">
        <button class="rounded bg-blue-500 px-2 py-1 text-xs text-white">Lihat</button>
    </a>

    <a href="{{ route('super-admin.kelas.edit', $value) }}">
        <button class="rounded bg-amber-500 px-2 py-1 text-xs text-white">Edit</button>
    </a>

    <form
        action="{{ route('super-admin.kelas.destroy', $value) }}"
        method="post"
        x-data
        @submit="
            confirm('Apakah Anda yakin?') || event.preventDefault()
        "
    >
        @csrf
        @method('DELETE')

        <button class="rounded bg-red-500 px-2 py-1 text-xs text-white">Hapus</button>
    </form>
</div>
