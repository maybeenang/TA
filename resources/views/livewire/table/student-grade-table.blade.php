<div class="w-full">

    @if (session()->has("message"))
        <div class="relative mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700" role="alert">
            <span class="block sm:inline">{{ session("message") }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="relative mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700" role="alert">
            <span class="block sm:inline">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <div class="min-w-max">
            <table class="mb-8 mt-2 w-full table-auto border-collapse border border-zinc-300 text-left">
                <thead>
                    <tr class="whitespace-nowrap uppercase">
                        @foreach ($this->headers() as $header)
                            <th class="border border-zinc-300 px-2 py-2">{{ $header }}</th>
                        @endforeach

                        <th class="border border-zinc-300 px-2 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->data() as $row)
                        <tr @class([
                        'whitespace-nowrap align-top ',
                        'bg-amber-100' => $editingId === $row['student_id'],
                        ])
                            @foreach ($row as $key => $cell)
                                @if (strpos($key, "id") !== false)
                                    @continue
                                @endif

                                <td class="border border-zinc-300 p-2">
                                    @if ($editingId === $row["student_id"] && $key !== "NIM" && $key !== "Nama" && $key !== "Total Nilai" && $key !== "Nilai")
                                        <input
                                            type="text"
                                            wire:model="editingData.{{ $key }}"
                                            class="max-w-[50px] p-0 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            @keydown.enter="$wire.saveEdit()"
                                            @keydown.escape="$wire.cancelEditing()"
                                        />
                                    @else
                                        {{ $cell }}
                                    @endif
                                </td>
                            @endforeach

                            <td class="border border-zinc-300 px-2 py-2 text-center">
                                @if ($editingId === $row["student_id"])
                                    <button wire:click="saveEdit"
                                        class="text-green-600 hover:text-green-900">
                                        <x-icons.check-alt-icon />
                                    </button>
                                    <button wire:click="cancelEditing"
                                        class="text-red-600 hover:text-red-900">
                                        <x-icons.close-alt-icon />
                                    </button>
                                @else

                                <button
                                    wire:click="startEditing({{ $row['student_id'] }})"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    <x-icons.pencil-icon />
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
