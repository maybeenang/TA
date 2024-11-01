<x-form class="" action="{{ route('admin.user.store') }}" method="POST">
    @csrf

    <x-form.item name="name" class="flex items-center gap-4">
        <x-form.label>Nama</x-form.label>
        <div>
            <x-input x-form:control required placeholder="John Doe" name="name" :value="old('name')" />
            <x-form.message />
        </div>
    </x-form.item>

</x-form>
