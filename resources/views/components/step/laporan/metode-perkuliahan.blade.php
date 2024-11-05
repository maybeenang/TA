<div class="min-h-2 space-y-2">
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
</div>
