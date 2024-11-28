<div
    x-data="{
        open: false,
        userId: {{ auth()->user()->id }},
        isMobile: window.innerWidth < 768,
        ev: null,
        init() {
            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth < 768
            })

            this.ev = new EventSource(
                `${window.mercureUrl}?topic=${encodeURIComponent('notification-user-' + this.userId)}`,
            )

            this.ev.onopen = (e) => {
                console.log('Connected to Mercure hub')
            }

            this.ev.onmessage = (e) => {
                const data = JSON.parse(e.data)
                $wire.call('receiveNotification', data.data)
            }

            this.ev.onerror = (e) => {
                console.error('Failed to connect to Mercure hub')
            }
        },
    }"
    class="relative"
>
    {{-- Notification Button --}}
    <button
        @click="open = !open"
        class="relative rounded-full p-2 transition hover:bg-gray-100 hover:text-yellow-500 focus:outline-none"
    >
        <x-icons.bell class="h-6 w-6" />
        @if ($unreadCount > 0)
            <span
                class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white"
            >
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Desktop Dropdown --}}
    <template x-if="!isMobile">
        <div
            x-show="open"
            @click.away="open = false"
            x-transition:enter="transition duration-200 ease-out"
            x-transition:enter-start="scale-95 transform opacity-0"
            x-transition:enter-end="scale-100 transform opacity-100"
            x-transition:leave="transition duration-100 ease-in"
            x-transition:leave-start="scale-100 transform opacity-100"
            x-transition:leave-end="scale-95 transform opacity-0"
            class="absolute right-0 z-50 mt-2 max-h-72 w-96 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg"
        >
            <div class="p-4">
                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-black">Notifikasi</h3>
                </div>

                <div class="mb-4 flex justify-end gap-2">
                    @if ($unreadCount > 0)
                        <button wire:click="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800">
                            Tandai semua dibaca
                        </button>
                        <button wire:click="clearAllNotifications" class="text-sm text-red-500 hover:text-red-800">
                            Hapus semua
                        </button>
                    @endif
                </div>

                <div class="space-y-4">
                    @forelse ($notifications as $notification)
                        <div
                            wire:key="notification-{{ $notification["id"] }}"
                            class="{{ $notification["read"] ? "bg-gray-50" : "bg-blue-50" }} rounded-lg p-3"
                        >
                            <p class="mb-2 text-right text-xs text-gray-500">{{ $notification["time"] }}</p>
                            <div class="flex items-start justify-between">
                                <h4 class="text-sm font-medium text-black">{{ $notification["title"] }}</h4>
                            </div>
                            <p class="mt-1 text-sm text-gray-600">{{ $notification["message"] }}</p>
                            @if (! $notification["read"])
                                <button
                                    wire:click="markAsRead({{ $notification["id"] }})"
                                    class="mt-2 text-xs text-blue-600 hover:text-blue-800"
                                >
                                    Tandai dibaca
                                </button>
                            @endif
                        </div>
                    @empty
                        <p class="py-4 text-center text-gray-500">Tidak ada notifikasi</p>
                    @endforelse
                </div>
            </div>
        </div>
    </template>

    {{-- Mobile Slide-over --}}
    <template x-if="isMobile">
        <div x-show="open" x-transition.opacity.duration.300ms class="fixed inset-0 z-50">
            {{-- Backdrop overlay --}}
            <div class="fixed inset-0 bg-gray-500/75" @click="open = false"></div>

            {{-- Slide panel --}}
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div
                    x-show="open"
                    x-transition:enter="transform transition duration-300 ease-in-out"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition duration-300 ease-in-out"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-md"
                >
                    <div class="flex h-full flex-col overflow-y-auto bg-white shadow-xl">
                        {{-- Header --}}
                        <div class="flex items-center justify-between border-b p-4">
                            <h2 class="text-lg font-semibold">Notifications</h2>
                            <button @click="open = false" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Close panel</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 p-4">
                            @if ($unreadCount > 0)
                                <div class="mb-4 flex justify-end">
                                    <button
                                        wire:click="markAllAsRead"
                                        class="text-sm text-blue-600 hover:text-blue-800"
                                    >
                                        Mark all as read
                                    </button>
                                </div>
                            @endif

                            <div class="space-y-4">
                                @forelse ($notifications as $notification)
                                    <div
                                        wire:key="notification-{{ $notification["id"] }}"
                                        class="{{ $notification["read"] ? "bg-gray-50" : "bg-blue-50" }} rounded-lg p-4"
                                    >
                                        <div class="flex items-start justify-between">
                                            <h4 class="text-sm font-medium">{{ $notification["title"] }}</h4>
                                            <span class="text-xs text-gray-500">{{ $notification["time"] }}</span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">{{ $notification["message"] }}</p>
                                        @if (! $notification["read"])
                                            <button
                                                wire:click="markAsRead({{ $notification["id"] }})"
                                                class="mt-2 text-xs text-blue-600 hover:text-blue-800"
                                            >
                                                Mark as read
                                            </button>
                                        @endif
                                    </div>
                                @empty
                                    <div class="py-4 text-center text-gray-500">No notifications</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
