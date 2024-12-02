<x-mail::message>
# Laporan berhasil diverifikasi

Selamat, laporan kelas **{{ $report->classroom->fullName }}** telah terverifikasi.

<x-mail::button :url="$url">
Lihat Laporan
</x-mail::button>

Terima Kasih, <br>
{{ config('app.name') }}
</x-mail::message>
