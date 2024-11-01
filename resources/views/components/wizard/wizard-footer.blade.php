<div class="w-full flex justify-between items-center">
    <div>
        @if ($this->currentStep > 0)
            <button wire:click="previousStep" class="bg-red-500 text-white px-4 py-2 rounded-md">
                Kembali
            </button>
        @endif
    </div>

    <div>

        @if ($this->currentStep < count($this->steps()) - 1 and $this->getCurrentStep()->showNext)
            <button wire:click="nextStep" class="bg-green-500 text-white px-4 py-2 rounded-md">
                Selanjutnya
            </button>
        @endif

        @if ($this->currentStep === count($this->steps()) - 1)
            <button wire:click="submitForm" class="bg-green-500 text-white px-4 py-2 rounded-md">
                Submit
            </button>
        @endif

    </div>
</div>
