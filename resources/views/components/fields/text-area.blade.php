@props([
    "label",
    "name",
    "value" => null,
])
<div class="flex flex-col md:flex-row">
    <label for="{{ $name }}" class="flex-1">
        {{ $label }}
    </label>

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        class="min-h-40 flex-1 rounded-md border border-gray-300"
        {{ $attributes }}
    ></textarea>
</div>
