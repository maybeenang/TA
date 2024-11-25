@php
    // check if admin or not
    $is_admin = Route::currentRouteName() === "admin.laporan.edit";

    // if admin then make route to admin, else make route to tenaga-pengajar
    $route = $is_admin ? "admin.laporan" : "tenaga-pengajar.laporan";
@endphp

<form class="min-h-2 space-y-2" action="{{ route($route . ".update", $laporan) }}" method="post">
    @csrf
    @method("PUT")

    <input type="hidden" name="step" value="metode-perkuliahan" />

    <h3 class="text-2xl font-semibold" id="metode-perkuliahan">Metode Perkuliahan</h3>
    <x-fields.text-area
        :value="old('teaching_methods', $laporan->teaching_methods)"
        name="teaching_methods"
        label="Metode Perkuliahan"
    />

    <x-fields.text-area
        :value="old('self_evaluation', $laporan->self_evaluation)"
        name="self_evaluation"
        label="Evaluasi Diri Perkuliahan"
    />

    <x-fields.text-area
        :value="old('follow_up_plan', $laporan->follow_up_plan)"
        name="follow_up_plan"
        label="Rencana Tindak Lanjut Perkuliahan"
    />

    <div class="flex justify-end">
        <x-button type="submit">Simpan</x-button>
    </div>
</form>
