@props([
    "value",
])

<div>
    <ul class="">
        @foreach ($value->progres() as $key => $item)
            <li class="flex items-center gap-2 whitespace-nowrap">
                <input type="checkbox" disabled @checked($item) />
                <span @class([
                    "line-through" => $item,
                ])>
                    {{ $this->convertCamelCase($key) }}
                </span>
            </li>
        @endforeach
    </ul>
</div>
