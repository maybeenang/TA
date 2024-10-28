@props(['value', 'color' => 'zinc'])
@php
    $text = App\Enums\ReportStatusEnum::from($value)->label();
    $color = App\Enums\ReportStatusEnum::from($value)->color();
@endphp
<div @class([
    'max-w-fit px-2 border-2 rounded-full text-sm ',
    match ($color) {
        'zinc' => 'bg-zinc-100 border-zinc-300 text-zinc-600',
        'emerald' => 'bg-emerald-100 border-emerald-300 text-emerald-600',
        'red' => 'bg-red-100 border-red-300 text-red-600',
        'yellow' => 'bg-yellow-100 border-yellow-300 text-yellow-600',
        'blue' => 'bg-blue-100 border-blue-300 text-blue-600',
        'amber' => 'bg-amber-100 border-amber-300 text-amber-600',
        default => 'bg-zinc-100 border-zinc-300 text-zinc-600',
    },
])>
    {{ $text }}
</div>
