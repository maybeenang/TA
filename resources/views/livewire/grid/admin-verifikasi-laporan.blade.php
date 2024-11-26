<section class="col-span-2 rounded-md border border-zinc-200 p-4 md:col-span-4">
    <h1 class="text-xl font-semibold">Verifikasi Laporan</h1>

    <section class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-5">
        @forelse ($this->data() as $item)
            <x-card.laporan-verifikasi-card :value="$item" />
        @empty
            <div class="col-span-2 md:col-span-5">
                <x-card.empty-card />
            </div>
        @endforelse
    </section>
</section>
