@props([
    'value',
])

<x-card class="">
    <x-card.header class="">
        <x-card.description class="line-clamp-1">
            {{ $value->name }}
        </x-card.description>
    </x-card.header>
    <x-card.content class="h-64">
        <div class="min-h-full">
            <img src="{{ route('signature.show', $value) }}" alt="signature" class="h-full w-full object-cover" />
        </div>
    </x-card.content>
    <x-card.footer class="flex justify-end gap-2">
        <a href="{{ route('signature.edit', $value) }}">
            <x-button variant="outline">Edit</x-button>
        </a>

        <form action="{{ route('signature.destroy', $value) }}" method="post">
            @csrf
            @method('DELETE')
            <x-button type="submit" variant="destructive">Hapus</x-button>
        </form>
    </x-card.footer>
</x-card>
