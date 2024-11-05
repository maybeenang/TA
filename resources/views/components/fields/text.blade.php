@props([
    "label",
    "name",
    "value" => null,
])
<div class="flex flex-col md:flex-row">
    <label for="{{ $name }}" class="flex-1">
        {{ $label }}
    </label>

    <input
        type="text"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        class="flex-1 rounded-md border border-gray-300 disabled:cursor-not-allowed disabled:bg-zinc-100"
        {{ $attributes }}
    />

    @error($name)
        <p {{ $attributes->merge(["class" => "text-[0.8rem] font-medium text-destructive"]) }}>
            {{ $message }}
        </p>
    @enderror
</div>
