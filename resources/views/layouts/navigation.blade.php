<nav x-data="{ open: false }" class="border-b border-gray-100 bg-yellow-500 text-white">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex items-center">
                <h1>Tahun Ajaran</h1>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center rounded-md border border-transparent bg-yellow-500 px-3 py-2 text-sm font-medium leading-4 text-gray-500 text-white transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                        >
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg
                                    class="h-4 w-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __("Profile") }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route("logout") }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                            >
                                {{ __("Log Out") }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <!--Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-white transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden text-white sm:hidden">
        <!-- Responsive Settings Options -->
        <div class="border-t border-gray-200 pb-1 pt-4 text-white">
            <div class="px-4">
                <div class="text-base font-medium">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-sm font-medium">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __("Profile") }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route("logout") }}">
                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                    >
                        {{ __("Log Out") }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
