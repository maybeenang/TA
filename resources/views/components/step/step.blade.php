@php
    $currentStep = $this->getCurrentStep();
@endphp

<form class="space-y-2">

    @foreach ($currentStep->fields() as $field)
        @php
            if (Str::contains($field->key, '.')) {
                $keys = explode('.', $field->key);

                $value = $this->laporan;

                foreach ($keys as $key) {
                    $value = $value[$key];
                    if (is_null($value)) {
                        break;
                    }
                }
            } else {
                $value = $this->laporan[$field->key];
            }
        @endphp
        <x-fields.text :label="$field->label" :name="$field->name" :value="old($field->name, $value)" />
    @endforeach

</form>
