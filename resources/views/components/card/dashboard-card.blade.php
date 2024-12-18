@props([
    'number' => 0,
])

<div
    {{
        $attributes->merge([
            'class' => 'grid rounded-md border p-4 gap-4 md:gap-12',
        ])
    }}
>
    <section>
        <p class="text-lg font-bold md:text-3xl">
            {{ $number }}
        </p>
    </section>
    <section class="self-end text-center text-xs md:text-lg">
        <p>
            {{ $slot }}
        </p>
    </section>
</div>
