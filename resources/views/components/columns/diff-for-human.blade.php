@props(['value'])

<div>
    {{ \Carbon\Carbon::make($value)->diffForHumans() }}
</div>
