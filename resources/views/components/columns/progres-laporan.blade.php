@props([
    "value",
])

<div>
    <ul class="">
        @foreach ($value->progres() as $key => $item)
            <li class="flex items-center gap-2 whitespace-nowrap text-xs">
                @if ($item)
                    <x-icons.check-alt-icon class="h-5 w-5 text-green-500" />
                @else
                    <x-icons.close-alt-icon class="h-5 w-5 text-red-500" />
                @endif
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
