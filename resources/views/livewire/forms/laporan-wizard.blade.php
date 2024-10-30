<div>
    <!--wizard header-->
    <x-wizard.wizard-header :steps="$this->steps()" :currentStep="$this->currentStep" />
    <!--end wizard header-->

    {{ $this->getCurrentStep()->title }}

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
