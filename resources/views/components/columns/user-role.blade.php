@props(['value'])

<div class="grid gap-1 justify-center place-items-center">
    @forelse ($value as $role)
        {{ App\Enums\RolesEnum::from($role->name)->badge() }}
    @empty
        <div class="max-w-fit px-2 bg-gray-500 rounded-md text-white text-sm">
            -
        </div>
    @endforelse
</div>
