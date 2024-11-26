@props([
    "value",
])

<x-card class="relative">
    <div class="absolute -top-2.5 right-2">
        <x-badges.report-status :value="$value->reportStatus->name" />
    </div>
    <x-card.header>
        <x-card.title class="line-clamp-2 text-sm">{{ $value->classroom->fullName }}</x-card.title>
        <x-card.description>
            {{ \Carbon\Carbon::make($value->updated_at)->diffForHumans() }}
        </x-card.description>
    </x-card.header>
    <x-card.footer class="flex justify-end gap-2">
        <a href="{{ route("admin.laporan.show", $value) }}">
            <x-button variant="outline">Lihat</x-button>
        </a>

        <a href="{{ route("admin.laporan.verifikasi.edit", $value) }}">
            <x-button>Verifikasi</x-button>
        </a>
    </x-card.footer>
</x-card>
