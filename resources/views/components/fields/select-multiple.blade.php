@props([
    "label",
    "name" => "",
    "value" => null,
    "options" => [],
    "placeholder" => "",
])
<div class="flex flex-col md:flex-row">
    <label for="{{ $name }}" class="flex-1">
        {{ $label }}
    </label>

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="select2-multiple flex-1 rounded-md border border-gray-300 disabled:cursor-not-allowed disabled:bg-zinc-100"
        multiple="multiple"
        {{ $attributes }}
    >
        @foreach ($options as $option)
            @php
                $value = is_array($value) ? $value : [$value];
                $selected = in_array($option["value"], $value);
            @endphp

            <option value="{{ $option["value"] }}" {{ $selected ? "selected" : "" }}>
                {{ $option["label"] }}
            </option>
        @endforeach
    </select>
    @push("scripts")
        <script>
            $(document).ready(function () {
                $('.select2-multiple').select2();
            });
        </script>
    @endpush
</div>
