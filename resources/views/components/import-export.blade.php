@props([
    'type' => 'pengguna',
    'label',
])
<div class="has-tooltip relative">
    <x-button class="relative bg-green-500 hover:bg-green-600" x-on:click.prevent="$refs.file.click()">
        Import {{ $label ?? $type }}
    </x-button>

    <span class="tooltip">
        <a href="{{ route('admin.export-template', $type) }}" class="text-blue-500 hover:text-blue-600">
            Unduh template
        </a>
    </span>

    <form
        action="{{ route('admin.import', $type) }}"
        class="sr-only"
        method="post"
        enctype="multipart/form-data"
        x-ref="form"
    >
        @csrf

        <input
            type="file"
            name="file"
            id="file"
            accept=".xlsx"
            class="hidden"
            x-ref="file"
            x-on:change="$refs.form.submit()"
        />
    </form>
</div>
