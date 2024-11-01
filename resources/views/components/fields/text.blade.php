@props(['label', 'name', 'value' => null])
<div class="flex">

    <label for="{{ $name }}" class="flex-1">
        {{ $label }}
    </label>

    <input type="text" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
        class="border border-gray-300 rounded-md flex-1">

</div>
