<div
    class="h-fit min-w-72 space-y-4"
    x-data="{
        ev: null,
        init() {
            this.ev = new EventSource(
                `${window.mercureUrl}?topic=${encodeURIComponent('report-updated')}`,
            )

            this.ev.onmessage = (e) => {
                $wire.call('refreshBadgeCount')
            }
        },
    }"
>
    @isset($menuData)
        @foreach ($menuData[0]->menu as $item)
            @isset($item->role)
                @if (! auth()->user()->hasRole($item->role))
                    @continue
                @endif
            @endisset

            <div class="divide-y-zinc-200 w-full divide-y-2 rounded-md border border-zinc-200">
                <header class="rounded-t-md bg-zinc-100 px-4 py-2">
                    <h3 class="">
                        {{ $item->name ?? 'Menu' }}
                    </h3>
                </header>
                @isset($item->submenu)
                    @foreach ($item->submenu as $subitem)
                        @php
                            if (isset($subitem->role)) {
                                if (is_array($subitem->role)) {
                                    if (
                                        ! auth()
                                            ->user()
                                            ->hasAnyRole($subitem->role)
                                    ) {
                                        continue;
                                    }
                                } else {
                                    if (
                                        ! auth()
                                            ->user()
                                            ->hasRole($subitem->role)
                                    ) {
                                        continue;
                                    }
                                }
                            }

                            $isActive = isset($subitem->url) && strpos(Route::currentRouteName(), $subitem->url) !== false;

                            if (! $isActive && isset($subitem->slug)) {
                                if (is_array($subitem->slug)) {
                                    $isActive = in_array(Route::currentRouteName(), $subitem->slug);
                                } else {
                                    $isActive = Route::currentRouteName() === $subitem->slug;
                                }
                            }
                        @endphp

                        <a
                            @class([
                                'flex cursor-pointer items-center justify-between gap-2 bg-white py-2 pl-4 pr-2 text-sm hover:bg-zinc-50',
                                'rounded-b-md' => $loop->last,
                                'bg-yellow-100' => $isActive,
                            ])
                            href="{{ route($subitem->url) }}"
                        >
                            <span>
                                {{ $subitem->name }}
                            </span>

                            @isset($subitem->badge)
                                @if ($badgeCount[$subitem->badge] ?? 0 > 0)
                                    <span class="rounded-sm bg-red-500 px-2 py-1 text-xs text-white">
                                        {{ $badgeCount[$subitem->badge] ?? 0 }}
                                    </span>
                                @endif
                            @endisset
                        </a>
                    @endforeach
                @endisset
            </div>
        @endforeach
    @endisset
</div>
