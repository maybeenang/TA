@props(['value', 'color' => 'zinc'])
@php
    $text = App\Enums\ReportStatusEnum::from($value)->label();
    $color = App\Enums\ReportStatusEnum::from($value)->color();
    $class = "bg-$color-100 border-$color-300 text-$color-600";
@endphp
<div @class(['max-w-fit px-2 border-2 rounded-full text-sm ', $class])>
    {{ $text }}
</div>
