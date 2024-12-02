@props([
    'value',
])

<div class="flex items-center justify-end gap-1">
    <a
        class="cursor-pointer rounded bg-blue-600 px-2 py-1 text-xs text-white"
        href="{{ route('admin.laporan.show', $value) }}"
    >
        Detail
    </a>

    <a
        class="cursor-pointer rounded bg-green-600 px-2 py-1 text-xs text-white"
        href="{{ route('admin.laporan.verifikasi.edit', $value) }}"
    >
        Verifikasi
    </a>

    <button
        class="rounded bg-red-600 px-2 py-1 text-xs text-white"
        x-on:click="$dispatch('open-tolak-laporan', { reportId: {{ $value->id }} })"
    >
        Tolak
    </button>
</div>
