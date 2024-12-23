<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">Edit Laporan Portofolio Perkuliahan</span>

        <section
            class="mx-auto max-w-screen-md rounded-md"
            x-data="{
                showNote:
                    {{ $report->reportStatus->name === 'ditolak' ? 'true' : 'false' }},
            }"
        >
            <x-form
                class="mx-auto max-w-md"
                action="{{ route('super-admin.laporan.update', $report->id) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <x-form.item name="">
                    <x-form.label>Nama Program Studi</x-form.label>
                    <x-input x-form:control :value="$report->classRoom->course->programStudi->name" disabled />
                </x-form.item>

                <x-form.item name="">
                    <x-form.label>Nama Mata Kuliah</x-form.label>
                    <x-input x-form:control :value="$report->classRoom->course->name" disabled />
                </x-form.item>

                <x-form.item name="">
                    <x-form.label>Nama Kelas</x-form.label>
                    <x-input x-form:control :value="$report->classRoom->name" disabled />
                </x-form.item>

                <x-form.item name="lecturer">
                    <x-form.label>Tenaga Pengajar</x-form.label>
                    <x-select class="" id="lecturer" name="lecturer">
                        <option
                            disabled
                            value="-"
                            {{ $report->lecturer_id === null ? 'selected' : '' }}
                        >
                            Pilih Tenaga Pengajar
                        </option>
                        @foreach ($lecturers as $lecturer)
                            <option
                                value="{{ $lecturer->id }}"
                                {{ $lecturer->id === $report->lecturer_id ? 'selected' : '' }}
                            >
                                {{ $lecturer->user->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-form.message />
                </x-form.item>

                <x-form.item name="reportStatus">
                    <x-form.label>Status Laporan</x-form.label>
                    <x-select
                        class=""
                        id="reportStatus"
                        name="reportStatus"
                        x-ref="reportStatusName"
                        x-on:change="
                            $refs.reportStatusName.value === 'ditolak'
                                ? (showNote = true)
                                : (showNote = false)
                        "
                    >
                        <option disabled value="-">Pilih Status Laporan</option>
                        @foreach ($reportStatus::toSelectArray() as $key => $value)
                            <option value="{{ $key }}" {{ $key === $report->reportStatus->name ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-form.message />
                </x-form.item>

                <template x-if="showNote">
                    <div class="">
                        <x-label class="text-right">
                            Catatan
                            <span class="text-xs">(optional)</span>
                        </x-label>
                        <x-textarea class="col-span-3" name="note">
                            {{ $report->note }}
                        </x-textarea>
                    </div>
                </template>

                <div class="flex justify-end">
                    <x-button type="submit">Submit</x-button>
                </div>
            </x-form>
        </section>
    </div>
</x-app-layout>
