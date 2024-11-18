@props([
    "value",
])

<div class="tabular-nums">
    {{ \Carbon\Carbon::make($value)->locale("id")->isoFormat("D MMMM Y") }}
    {{ $value->format("H:i") }}
</div>
