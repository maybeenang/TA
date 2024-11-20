<x-app-layout>
    <x-alert.flash />
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Verifikasi Laporan
        </span>

        <div class="flex gap-4">
            <div class="max-w-md">
                <x-form class="" method="POST" action="{{ route('admin.kelas.store') }}">
                    @csrf

                    <x-form.item class="space-y-3" name="notification">
                        <x-form.label>Pilih tanda tangan</x-form.label>
                        <x-radio-group x-form:control name="notification" class="grid grid-cols-4 space-y-1">
                            @forelse ($signatures as $signature)
                                <x-form.item class="flex">
                                    <x-radio-group.item x-form:control value="{{$signature->id}}" />
                                    <x-form.label class="font-normal">
                                        <img
                                            src="{{ route("admin.signature.show", $signature) }}"
                                            alt="{{ $signature->name }}"
                                            class="h-20 w-20 object-cover"
                                        />
                                    </x-form.label>
                                </x-form.item>
                            @empty
                                <span>Tidak ada data</span>
                            @endforelse
                        </x-radio-group>
                        <x-form.description>
                            Pilih tanda tangan sebagai bukti bahwa laporan telah terverifikasi. atau
                            <a
                                href="{{ route("admin.signature.create") }}"
                                class="font-semibold text-blue-800 underline"
                            >
                                tambahkan tanda tangan baru
                            </a>
                        </x-form.description>
                    </x-form.item>

                    <div class="flex justify-end">
                        <x-button type="submit">Verifikasi</x-button>
                    </div>
                </x-form>
            </div>

            <div class="w-full">
                <livewire:pdf-viewer :report="$laporan" />
            </div>
        </div>
    </div>
</x-app-layout>
