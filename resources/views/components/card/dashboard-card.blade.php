@props(["number" => 0])

<div class="grid h-40 rounded-md border border-zinc-200 bg-white p-4">
    <section>
        <p class="text-4xl font-bold">
            {{ $number }}
        </p>
    </section>
    <section class="self-end text-center">
        <p>
            {{ $slot }}
        </p>
    </section>
</div>
