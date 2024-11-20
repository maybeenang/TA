<div class="container mx-auto p-6 text-xs">
    <h1 class="mb-8 text-center text-xl font-bold">BUKTI VERIFIKASI LAPORAN PORTOFOLIO PERKULIAHAN</h1>
    <table class="w-full border-collapse">
        <tbody>
            <tr class="border-b">
                <td colspan="2" class="py-2 font-semibold">Terverifikasi oleh:</td>
            </tr>
            <tr class="border-b">
                <td class="py-1 font-medium">Nama</td>
                <td class="py-1">: {{ $verifikasiData->name }}</td>
            </tr>
            <tr class="border-b">
                <td class="py-1 font-medium">NIP</td>
                <td class="py-1">: {{ $verifikasiData->nip }}</td>
            </tr>
            <tr class="border-b">
                <td class="py-1 font-medium">Email</td>
                <td class="py-1">: {{ $verifikasiData->email }}</td>
            </tr>
            <tr class="border-b">
                <td colspan="2" class="py-2 font-semibold">Detail Laporan:</td>
            </tr>
            <tr class="border-b">
                <td class="py-1 font-medium">Dosen Pengampu</td>
                <td class="py-1">: {{ $detailLaporan->dosenPengampu }}</td>
            </tr>
            <tr class="border-b">
                <td class="py-1 font-medium">Kelas</td>
                <td class="py-1">: {{ $detailLaporan->kelas }}</td>
            </tr>
            <tr class="border-b">
                <td class="py-1 font-medium">Mata Kuliah</td>
                <td class="py-1">: {{ $detailLaporan->mataKuliah }}</td>
            </tr>
            <tr>
                <td class="py-1 font-medium">Tahun Ajaran</td>
                <td class="py-1">
                    :
                    {{ $detailLaporan->tahunAkademik }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="mt-8 text-center">
        @if ($laporan->reportStatus->name !== $reportStatus::TERVERIFIKASI->value)
            <span class="font-bold text-red-800">Laporan belum diverifikasi</span>
        @else
            <span class="font-bold text-green-800">Laporan telah diverifikasi</span>
        @endif
    </div>

    @if ($laporan->reportStatus->name === $reportStatus::TERVERIFIKASI->value)
        <div class="mt-16 border-t pt-4 text-center font-normal">
            <p>
                {{ \Carbon\Carbon::make($verifikasiData->verified_at)->locale("id")->isoFormat("dddd, DD MMMM YYYY") }}
            </p>
        </div>

        <div class="mt-4 text-center">
            <div class="mx-auto mb-2 h-28 w-28">
                @inlinedImage(asset("storage/signatures/" . $verifikasiData->signature) ?? "")
            </div>
            <p>
                {{ $verifikasiData->name }}
            </p>
        </div>
    @endif
</div>
