<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Buat Laporan Portofolio Perkuliahan
        </span>

        <section class="mx-auto max-w-screen-md rounded-md">
            <x-form class="mx-auto max-w-md" action="{{ route('admin.laporan.store') }}" method="POST">
                @csrf

                <x-alert variant="destructive">
                    <x-lucide-triangle-alert class="size-4" />
                    <x-alert.title>Perhatian !</x-alert.title>
                    <x-alert.description>
                        Halaman ini digunakan untuk membuat laporan portofolio perkuliahan yang tidak dimiliki suatu
                        kelas.
                    </x-alert.description>
                </x-alert>

                <x-form.item name="classroom">
                    <x-form.label>Kelas</x-form.label>
                    <x-select class="" id="classroom" name="classroom">
                        <option disabled selected value="-">Pilih Kelas</option>

                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom["value"] }}">{{ $classroom["label"] }}</option>
                        @endforeach
                    </x-select>
                    <x-form.message />
                </x-form.item>

                <x-button type="submit">Submit</x-button>
            </x-form>
        </section>
    </div>
</x-app-layout>
