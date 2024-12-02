<x-mail::message>
# Verifikasi Laporan

Laporan kelas **{{ $report?->classroom?->fullName }}** telah dikirim dan menunggu untuk diverifikasi.

<x-mail::button :url="$url">
Verifikasi Laporan
</x-mail::button>

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
