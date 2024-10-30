@props(['step', 'isLastIndex', 'isCurrentStep'])
<div class="flex flex-col gap-2 justify-center">
    <div class="flex items-center justify-start">
        <button @class([
            'bg-red-400 rounded-full w-10 h-10',
            'bg-green-400' => $isCurrentStep,
        ])>
            a
        </button>

        @if (!$isLastIndex)
            <div class="flex-1 bg-black h-2 min-w-10">

            </div>
        @endif

    </div>
    {{ $step->title }}
</div>
