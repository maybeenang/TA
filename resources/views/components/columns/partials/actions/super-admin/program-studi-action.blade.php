@props([
    'value',
])

<div class="flex items-center justify-end gap-2 text-white">
    <a href="{{ route('super-admin.program-studi.edit', $value) }}">
        <button class="rounded bg-amber-500 px-2 py-1 text-xs text-white">Edit</button>
    </a>

    <form
        action="{{ route('super-admin.program-studi.destroy', $value) }}"
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
