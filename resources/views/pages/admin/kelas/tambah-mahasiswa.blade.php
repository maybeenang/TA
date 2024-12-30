<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Tambah Mahasiswa Kelas {{ $kelas->fullName }}</span>

        <x-form class="mx-auto max-w-md" method="POST" action="{{ route('admin.kelas.store-mahasiswa', $kelas->id) }}">
            @csrf

            <x-form.item name="name">
                <x-form.label>Nama Kelas</x-form.label>
                <x-input x-form:control disabled name="name" :value="$kelas->fullName" />
                <x-form.message />
            </x-form.item>

            <x-form.item name="students">
                <x-form.label>Pilih Mahasiswa</x-form.label>
                <select
                    name="students[]"
                    id="students"
                    class="select2-multiple w-full rounded-md border border-gray-300"
                    multiple="multiple"
                >
                    @foreach ($students as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
                @push('scripts')
                    <script>
                        $(document).ready(function () {
                            $('.select2-multiple').select2();
                        });
                    </script>
                @endpush

                <x-form.message />
            </x-form.item>

            <div class="flex justify-end">
                <x-button type="submit">Submit</x-button>
            </div>
        </x-form>
    </div>
</x-app-layout>
