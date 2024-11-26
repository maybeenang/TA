<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Tambah Tanda Tangan
        </span>

        <div class="mx-auto max-w-md" x-image-viewer>
            <h1 class="text-center text-xl font-semibold">Tambah Tanda Tangan</h1>
            <x-form class="" method="POST" action="{{ route('admin.signature.store') }}" enctype="multipart/form-data">
                @csrf

                <x-form.item name="image">
                    <x-form.label>Upload tanda tangan</x-form.label>
                    <x-input
                        x-image-viewer:input
                        x-form:control
                        name="image"
                        type="file"
                        :value="old('image')"
                        class="cursor-pointer"
                        accept="image/*"
                    />
                    <x-form.description>
                        Unggah tanda tangan yang akan digunakan untuk melakukan verifikasi laporan.
                        <span class="font-semibold">Catatan:</span>
                        Format file yang diterima adalah
                        <span class="font-semibold">.png</span>
                        atau
                        <span class="font-semibold">.jpg</span>
                        .
                        <br />
                        Ukuran file maksimal adalah
                        <span class="font-semibold">2 MB</span>
                    </x-form.description>
                    <x-form.message />
                </x-form.item>

                <div class="h-28 w-28 bg-gray-200" x-ref="image-previewer-container">
                    <img x-ref="image-previewer" />
                </div>

                <x-form.item name="name">
                    <x-form.label>
                        Nama Tanda Tangan
                        <span class="text-xs">(optional)</span>
                    </x-form.label>
                    <x-input x-form:control name="name" placeholder="signature-1" :value="old('name')" />
                    <x-form.message />
                </x-form.item>

                <div class="flex justify-end">
                    <x-button type="submit">Submit</x-button>
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>
