@props(['value'])
<div class="flex justify-center items-center">
    @if (!empty($this->partialActions))
        @foreach ($this->partialActions as $item)
            <x-dynamic-component :component="$item" />
        @endforeach
    @endif
</div>
