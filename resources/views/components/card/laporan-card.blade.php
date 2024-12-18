@props([
    'value',
    'role' => 'admin',
])

<x-card class="relative">
    <div class="absolute -top-2.5 right-2">
        <x-badges.report-status :value="$value->reportStatus->name" />
    </div>
    <x-card.header>
        <x-card.title>{{ $value->classroom->fullName }}</x-card.title>
        <x-card.description>
            {{ \Carbon\Carbon::make($verifikasiData?->verified_at ?? now())->locale('id')->isoFormat('dddd, DD MMMM YYYY') ?? '-' }}
        </x-card.description>
    </x-card.header>
    <x-card.content class="min-h-32">
        <p class="line-clamp-4">
            {{ $value->self_evaluation ?? '-' }}
        </p>
    </x-card.content>
    <x-card.footer class="flex justify-end gap-2">
        <a href="{{ route($role . '.laporan.show', $value) }}">
            <x-button variant="outline">Lihat</x-button>
        </a>

        <a href="{{ route('laporan.print', $value) }}">
            <x-button>Unduh PDF</x-button>
        </a>
    </x-card.footer>
</x-card>
