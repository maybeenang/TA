@props([
    "label",
    "name",
    "value" => null,
])
<div class="flex flex-col md:flex-row">
    <label for="{{ $name }}" class="flex-1">
        {{ $label }}
    </label>
    <div class="flex-1">
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            class="min-h-40 w-full rounded-md border border-gray-300"
            {{ $attributes }}
        >
{{ $value }}</textarea
        >

        @error($name)
            <p {{ $attributes->merge(["class" => "text-[0.8rem] font-medium text-destructive"]) }}>
                {{ $message }}
            </p>
        @enderror
    </div>
</div>
