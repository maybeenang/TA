<div class="min-h-2 space-y-2">
    <h3 class="text-lg font-semibold" id="metode-perkuliahan">Metode Perkuliahan</h3>
    <x-fields.text-area :value="$laporan->classroom->name" name="classroom_name" label="Metode Perkuliahan" />

    <x-fields.text-area :value="$laporan->classroom->name" name="classroom_name" label="Evaluasi Diri Perkuliahan" />

    <x-fields.text-area
        :value="$laporan->classroom->name"
        name="classroom_name"
        label="Rencana Tindak Lanjut Perkuliahan"
    />
</div>
