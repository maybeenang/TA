@props([
    "value",
])
<div>
    <x-dynamic-component component="badges.report-status" :value="$value->reportStatus->name" />

    @if ($value->reportStatus->name == "ditolak")
        <div class="mt-2 text-xs">
            Catatan :
            <span class="text-red-500">{{ $value?->note ?? "-" }}</span>
        </div>
    @endif
</div>
