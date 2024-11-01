@props(['step', 'isLastIndex', 'isCurrentStep'])
<li class="relative z-10">
    <div @class([
        "flex justify-center after:content-['']",
        'after:absolute after:top-5 after:-right-12 after:-z-10' => !$isLastIndex,
        'after:bg-gray-900 after:w-full after:h-[2px]' => !$isLastIndex,
    ])>
        <button @class([
            'rounded-full w-10 h-10',
            'bg-green-400' => $isCurrentStep,
            'bg-red-400' => !$isCurrentStep,
        ])>
            a
        </button>

    </div>

    <div>
        <span>
            {{ $step->title }}
        </span>
    </div>

</li>
