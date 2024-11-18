@props([
    "value",
])

<div>
    <ul class="">
        @foreach ($value->progres() as $key => $item)
            <li class="flex items-center gap-2 whitespace-nowrap text-xs">
                <input type="checkbox" disabled @checked($item) />
                <a
                    href="{{ route("tenaga-pengajar.laporan.edit", $value) . "#{$this->convertKebabCase($key)}" }}"
                    @class([
                        "text-blue-800 hover:underline" => ! $item,
                        "line-through" => $item,
                    ])
                >
                    {{ $this->convertCamelCase($key) }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
