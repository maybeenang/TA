<div x-data="{ dialogOpen: false }" x-modelable="dialogOpen" x-on:close-modal.window="dialogOpen = false"
    {{ $attributes->twMerge('') }}>
    {{ $slot }}
</div>
