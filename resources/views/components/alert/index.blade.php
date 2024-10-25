@props([
    'variant' => null,
])

@inject('alert', 'App\Services\AlertCvaService')

<div x-data="{
    show: true,
    close() {
        this.show = false
    }
}" x-show="show" {{ $attributes->twMerge($alert(['variant' => $variant])) }}>
    {{ $slot }}
    <div @click="close()"
        class=" absolute top-0 right-0 w-6 h-6 flex items-center justify-center rounded-full cursor-pointer">
        <x-icons.close-icon />
    </div>
</div>
