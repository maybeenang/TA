@props(['value'])

<div class="flex flex-wrap gap-1">
    @forelse ($value as $role)
        {{ App\Enums\RolesEnum::from($role->name)->badge() }}
    @empty
        <div class="max-w-fit px-2 bg-zinc-100 border-zinc-300 border-2 rounded-full text-zinc-600 text-sm">
            Tidak ada
        </div>
    @endforelse
</div>
