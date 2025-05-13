<x-app-layout>
    <div
        class="min-h-screen rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Pengaturan</span>

        <div class="my-8 max-w-xl">
            <h2 class="mb-4 text-lg font-semibold">Program Studi</h2>
            <form class="space-y-4 px-6">
                <div>
                    <x-input-label for="program_studi" value="Nama Program Studi" />
                    <x-input id="program_studi" name="program_studi" type="text" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </div>

        <div class="mb-8 max-w-fit">
            <h2 class="mb-4 text-lg font-semibold">Data Akademik</h2>
            <div class="space-y-4">
                <table class="table table-auto divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                Terakhir Di Update
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                Terakhir Di Sinkron
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($dataAkademik as $item)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $item['title'] }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $item['last_updated'] }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $item['last_synced'] }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    <div class="flex space-x-2">
                                        <x-button>{{ $item['export'] }}</x-button>
                                        <x-button>{{ $item['import'] }}</x-button>
                                        <x-button>{{ $item['sync'] }}</x-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
