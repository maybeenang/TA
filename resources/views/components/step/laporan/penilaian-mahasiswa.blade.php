<div class="space-y-2">
    @if (\Route::currentRouteName() === "tenaga-pengajar.laporan.edit")
        <h3 class="text-2xl font-semibold" id="penilaian-mahasiswa">Penilaian Mahasiswa</h3>
    @endif

    <livewire:table.student-grade-table :$laporan />
</div>
