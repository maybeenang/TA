<x-mail::message>
# Status Laporan anda berubah

Laporan kelas **{{ $report->classroom->fullName }}** berubah menjadi **{{ $report->reportStatus->name }}**.

<x-mail::button :url="$url">
Lihat Laporan
</x-mail::button>

Terima Kasih,<br />
{{ config('app.name') }}
</x-mail::message>
