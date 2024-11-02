@php
    $currentStep = $this->getCurrentStep();
@endphp

<form class="space-y-2">
    @foreach ($currentStep->fields() as $field)
        <x-fields.text :label="$field->label" :name="$field->name" :value="old($field->name)" />
    @endforeach
</form>
