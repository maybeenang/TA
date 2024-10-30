<div>
    <!--wizard header-->
    <ul>
        @foreach ($this->steps() as $step)
            <li>
                <button wire:click="goToStep({{ $loop->index }})">
                    {{ $step->title }}
                </button>
            </li>
        @endforeach
    </ul>
    <!--end wizard header-->

    {{ $this->currentStep }}

    <!--wizard forms-->
    <x-dynamic-component :component="$this->getCurrentStep()->component" />
    <!--end wizard forms-->

    <!--wizard footer-->
    <div class="w-full flex justify-between items-center">
        @if ($this->currentStep > 0)
            <button wire:click="previousStep">
                Previous
            </button>
        @endif

        @if ($this->currentStep < count($this->steps()) - 1)
            <button wire:click="nextStep">
                Next
            </button>
        @endif

        @if ($this->currentStep === count($this->steps()) - 1)
            <button wire:click="submitForm">
                Submit
            </button>
        @endif
    </div>

</div>
