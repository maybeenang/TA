@props(['steps', 'currentStep'])
<div class="mx-auto w-fit ">
    <ul class="flex md:gap-10 text-center">
        @foreach ($steps as $step)
            @php
                $isLastIndex = $loop->last;
                $isCurrentStep = $currentStep === $loop->index;
            @endphp
            <x-wizard.step-button :$step :$isLastIndex :$isCurrentStep />
        @endforeach
    </ul>
</div>
