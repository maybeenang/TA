<div class="space-y-20">
    <!--wizard header-->
    <x-wizard.wizard-header :steps="$this->steps()" :currentStep="$this->currentStep" />
    <!--end wizard header-->

    <!--wizard forms-->
    <x-dynamic-component :component="$this->getCurrentStep()->component" />
    <!--end wizard forms-->

    <!--wizard footer-->
    <x-wizard.wizard-footer />

</div>
