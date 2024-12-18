<div class="col-span-2 flex items-center justify-between rounded-md border border-zinc-200 bg-white p-4">
    <section class="flex items-center gap-2">
        <div class="h-[50px] w-[50px] rounded-full border border-zinc-300">
            <img
                src=" {{ auth()->user()->profile_picture_path }} "
                alt=" {{ auth()->user()->name }} "
                class="h-full w-full rounded-full object-cover"
            />
        </div>

        <div class="">
            <span class="font-semibold">Selamat Datang</span>
            <p class="line-clamp-1">{{ auth()->user()->name ?? '-' }}</p>
        </div>
    </section>
    <a href="{{ route('profile.edit') }}">
        <x-button class="bg-blue-500 text-white hover:bg-blue-800">Edit Profil</x-button>
    </a>
</div>
