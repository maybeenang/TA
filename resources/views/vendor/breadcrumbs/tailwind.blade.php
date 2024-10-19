@unless ($breadcrumbs->isEmpty())
    <nav class=" mb-2 ">
        <ol class="p-4 py-2 rounded flex flex-wrap bg-zinc-100 text-sm border border-zinc-200 ">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li>
                        <a href="{{ $breadcrumb->url }}"
                            class="text-blue-600 hover:text-blue-900 hover:underline focus:text-blue-900 focus:underline">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li>
                        {{ $breadcrumb->title }}
                    </li>
                @endif

                @unless ($loop->last)
                    <li class="text-gray-500 px-2">
                        /
                    </li>
                @endunless
            @endforeach
        </ol>
    </nav>
@endunless
