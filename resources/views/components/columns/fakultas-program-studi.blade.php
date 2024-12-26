@props([
    'value',
])

<div>
    <ul>
        @forelse ($value->programStudis as $item)
            <li>
                {{ $item->name }}
            </li>
        @empty
            <li>
                <span class="text-muted-foreground">-</span>
            </li>
        @endforelse
    </ul>
</div>
