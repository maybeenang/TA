<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'text-sm bg-blue-500 text-white px-2 py-1 rounded-sm',
    ]) }}>
    {{ $slot }}
</button>
