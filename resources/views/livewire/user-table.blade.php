<div>
    @if (session()->has("message"))
        <div class="relative mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700" role="alert">
            <span class="block sm:inline">{{ session("message") }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($users as $user)
                    <tr class="{{ $editingId === $user->id ? "bg-blue-50" : "" }}">
                        <td class="whitespace-nowrap px-6 py-4">{{ $user->id }}</td>

                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($editingId === $user->id)
                                <input
                                    type="text"
                                    wire:model="editingData.name"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @keydown.enter="$wire.saveEdit()"
                                    @keydown.escape="$wire.cancelEdit()"
                                />
                            @else
                                {{ $user->name }}
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($editingId === $user->id)
                                <input
                                    type="email"
                                    wire:model="editingData.email"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @keydown.enter="$wire.saveEdit()"
                                    @keydown.escape="$wire.cancelEdit()"
                                />
                            @else
                                {{ $user->email }}
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            @if ($editingId === $user->id)
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="saveEdit" class="text-green-600 hover:text-green-900">
                                        <x-icons.check-alt-icon />
                                    </button>
                                    <button wire:click="cancelEdit" class="text-red-600 hover:text-red-900">
                                        <x-icons.close-alt-icon />
                                    </button>
                                </div>
                            @else
                                <button
                                    wire:click="startEditing({{ $user->id }})"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                        ></path>
                                    </svg>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
