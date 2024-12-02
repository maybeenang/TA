<x-mail::message>
# Laporan anda ditolak

Laporan kelas **{{ $report?->classroom?->fullName }}** berubah menjadi **{{ $report->reportStatus->name }}**. dengan catatan:
**{{ $report?->note ?? 'Tidak ada' }}**

<x-mail::button :url="$url">
Lihat Laporan
</x-mail::button>

Terima Kasih,<br />
{{ config('app.name') }}
</x-mail::message>
