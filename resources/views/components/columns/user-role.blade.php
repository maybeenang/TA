@props(['value'])

<div>
    @foreach ($value as $role)
        {{ $role->name }}
    @endforeach
</div>
