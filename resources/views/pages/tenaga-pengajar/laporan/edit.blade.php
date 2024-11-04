<x-app-layout>
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Buat Laporan Portofolio Perkuliahan
        </span>

        <section class="flex gap-8">
            <!--form-->
            <form class="js-toc-content w-full space-y-8">
                <x-step.laporan.informasi-umum :laporan="$laporan" />

                <x-step.laporan.metode-perkuliahan :laporan="$laporan" />

                <x-step.laporan.metode-evaluasi :laporan="$laporan" />

                <x-step.laporan.presensi-dan-keaktifan :laporan="$laporan" />

                <x-step.laporan.kriteria-penilaian :laporan="$laporan" />

                <x-step.laporan.penilaian-mahasiswa :laporan="$laporan" />
            </form>

            <!--navigasi-->
            <div class="js-toc sticky top-5 hidden h-fit min-w-44 md:block"></div>
        </section>
    </div>

    @pushOnce("scripts")
    <script>
        tocbot.init({
            tocSelector: '.js-toc',
            contentSelector: '.js-toc-content',
            headingSelector: 'h3',
            hasInnerContainers: true,
        });
    </script>
    @endPushOnce
</x-app-layout>
