@props(["number" => 0])

<div
    {{
        $attributes->merge([
            "class" => "grid rounded-md border border-zinc-200 bg-white p-4 gap-4",
        ])
    }}
>
    <section>
        <p class="text-lg font-bold md:text-3xl">
            {{ $number }}
        </p>
    </section>
    <section class="self-end text-center text-xs">
        <p>
            {{ $slot }}
        </p>
    </section>
</div>
