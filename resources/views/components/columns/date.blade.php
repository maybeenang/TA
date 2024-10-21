@props(['value'])

<div>
    {{ \Carbon\Carbon::make($value)->locale('id')->isoFormat('D MMMM Y') }}
</div>
