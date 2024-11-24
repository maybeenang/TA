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
        class="select2 flex-[0.95] rounded-md border border-gray-300 disabled:cursor-not-allowed disabled:bg-zinc-100"
        {{ $attributes }}
    >
        @if ($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif

        @foreach ($options as $option)
            <option value="{{ $option["value"] }}" {{ $option["value"] == $value ? "selected" : "" }}>
                {{ $option["label"] }}
            </option>
        @endforeach
    </select>
    @push("scripts")
        <script>
            $(document).ready(function () {
                $('.select2').select2();
            });
        </script>
    @endpush
</div>
