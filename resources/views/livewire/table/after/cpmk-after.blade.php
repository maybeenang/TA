<div>
    @foreach ($this->dialogs() as $dialog)
        <x-dynamic-component :component="$dialog->component" :model="$dialog->model" />
    @endforeach
</div>
