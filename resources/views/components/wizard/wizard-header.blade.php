@props(['steps', 'currentStep'])
<div class="bg-red-50 w-fit mx-auto">
    <ul class="flex">
        @foreach ($steps as $step)
            <li>
                @php
                    $isLastIndex = $loop->last;
                    $isCurrentStep = $currentStep === $loop->index;
                @endphp
                <x-wizard.step-button :$step :$isLastIndex :$isCurrentStep />
            </li>
        @endforeach
    </ul>
</div>
