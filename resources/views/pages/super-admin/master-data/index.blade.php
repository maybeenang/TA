<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Master Data</span>

        @env('local')
            <form action="{{ route('super-admin.scrape') }}" method="post" class="flex items-center justify-end">
                @csrf
                <x-button type="submit" class="">Import Data</x-button>
            </form>
        @endenv

        <section class="grid grid-cols-2 gap-2 md:grid-cols-5">
            @foreach ($menus as $menu)
                <a
                    href="{{ route($menu?->route ?? 'super-admin.master-data.index') }}"
                    class="flex flex-col items-center justify-center gap-4 rounded-md border border-zinc-300 p-2 py-4 shadow transition-all hover:bg-zinc-100 hover:shadow-none"
                >
                    <i class="{{ $menu->icon }} text-4xl"></i>
                    {{ $menu->name }}
                </a>
            @endforeach
        </section>
    </div>
</x-app-layout>
