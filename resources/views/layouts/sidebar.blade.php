<div class="md:min-h-screen min-w-72 space-y-4">
    @isset($menuData)
        @foreach ($menuData[0]->menu as $item)
            <div class="w-full border border-zinc-200 rounded-md divide-y-zinc-200 divide-y-2">
                <header class="bg-zinc-100 px-4 py-2 rounded-t-md">
                    <h3 class="">
                        {{ $item->name ?? 'Menu' }}
                    </h3>
                </header>
                @isset($item->submenu)
                    @foreach ($item->submenu as $subitem)
                        @php

                            $isActive =
                                isset($subitem->url) && strpos(Route::currentRouteName(), $subitem->url) !== false;

                            if (!$isActive) {
                                $isActive =
                                    isset($subitem->slug) &&
                                    strpos(Route::currentRouteName(), $subitem->slug) !== false;
                            }

                        @endphp
                        <a @class([
                            'block py-2 px-4 cursor-pointer hover:bg-zinc-50 bg-white text-sm',
                            'rounded-b-md' => $loop->last,
                            'bg-yellow-100' => $isActive,
                        ]) href="{{ route($subitem->url) }}">
                            {{ $subitem->name }}
                        </a>
                    @endforeach
                @endisset
            </div>
        @endforeach
    @endisset
</div>
