@props([
    "value",
])

<x-card class="relative">
    <div class="absolute -top-2.5 right-2">
        <x-badges.report-status :value="$value->reportStatus->name" />
    </div>
    <x-card.header>
        <x-card.title>{{ $value->classroom->fullName }}</x-card.title>
        <x-card.description>
            {{ \Carbon\Carbon::make($verifikasiData?->verified_at ?? now())->locale("id")->isoFormat("dddd, DD MMMM YYYY") ?? "-" }}
        </x-card.description>
    </x-card.header>
    <x-card.content class="text-xs">
        {{ $value->self_evaluation ?? "-" }}
    </x-card.content>
    <x-card.footer class="flex justify-end gap-2">
        <a href="{{ route("laporan.pdf", $value) }}">
            <x-button variant="outline">Lihat</x-button>
        </a>

        <a href="{{ route("laporan.print", $value) }}">
            <x-button>Unduh PDF</x-button>
        </a>
    </x-card.footer>
</x-card>
