@props([
    "value",
])
@php
    $lecturerName = App\Models\ClassRoom::find($value)?->lecturer?->user?->name;
@endphp

<div class="">
    @if ($lecturerName)
        {{ $lecturerName }}
    @else
        <p class="text-gray-400">Belum ada</p>

        <x-dialog>
            <x-dialog.trigger class="text-sm text-blue-500">Tambah</x-dialog.trigger>
            <x-dialog.content>
                <x-dialog.header>
                    <x-dialog.title>Tambah Tenaga Pengajar</x-dialog.title>
                    <x-dialog.description>
                        Kelas ini belum memiliki tenaga pengajar. Silahkan tambahkan tenaga pengajar untuk kelas ini.
                    </x-dialog.description>
                </x-dialog.header>

                @php
                    $lecturers = $allLecturers;
                    $lecturers = $lecturers->map(function ($lecturer) {
                        return [
                            "id" => $lecturer->id,
                            "name" => $lecturer?->user?->name,
                        ];
                    });

                    $classRoomName = $this->getRowData($value)->name;
                    $courseName = $this->getRowData($value)->course->name;
                @endphp

                <form wire:submit="addLecture({{ $value }})">
                    <div class="grid gap-4 py-4">
                        <div class="grid grid-cols-4 items-center gap-4">
                            <x-label htmlFor="name" class="text-right">Mata Kuliah</x-label>
                            <x-input id="name" readonly value="{{ $courseName }}" class="col-span-3" />
                        </div>
                        <div class="grid grid-cols-4 items-center gap-4">
                            <x-label htmlFor="username" class="text-right">Kelas</x-label>
                            <x-input id="username" readonly value="{{ $classRoomName }}" class="col-span-3" />
                        </div>
                        <div class="grid grid-cols-4 items-center gap-4">
                            <x-label htmlFor="username" class="text-right">Tenaga Pengajar</x-label>
                            <x-select
                                autofocus
                                id="lecturer_id"
                                name="lecturer_id"
                                class="col-span-3"
                                wire:model="lecturerId"
                            >
                                <option value="">Pilih Tenaga Pengajar</option>
                                @foreach ($lecturers as $lecturer)
                                    <option value="{{ $lecturer["id"] }}">{{ $lecturer["name"] }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                    <x-dialog.footer>
                        <x-button type="submit">Save changes</x-button>
                    </x-dialog.footer>
                </form>
            </x-dialog.content>
        </x-dialog>
    @endif
</div>
