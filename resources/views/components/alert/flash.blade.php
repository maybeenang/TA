@if (session("success"))
    <x-alert>
        <x-alert.title>Berhasil !</x-alert.title>
        <x-alert.description>
            {{ session("success") }}
        </x-alert.description>
    </x-alert>
@endif

@if (session("error"))
    <x-alert variant="destructive">
        <x-alert.title>Perhatian !</x-alert.title>
        <x-alert.description>
            {{ session("error") }}
        </x-alert.description>
    </x-alert>
@endif
