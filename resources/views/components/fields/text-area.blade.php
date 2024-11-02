@props(['label', 'name', 'value' => null])
<div class="flex flex-col md:flex-row">

    <label for="{{ $name }}" class="flex-1">
        {{ $label }}
    </label>

    <textarea name="{{ $name }}" id="{{ $name }}" class="border border-gray-300 min-h-40 rounded-md flex-1"></textarea>

</div>
