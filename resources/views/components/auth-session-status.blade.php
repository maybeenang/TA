@props([
    "status",
])

@if ($status)
    <div {{ $attributes->merge(["class" => "font-medium text-sm text-green-900"]) }}>
        {{ $status }}
    </div>
@endif
