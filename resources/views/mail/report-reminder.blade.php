<x-mail::message>
# Pengingat Laporan Portofolio Perkuliahan

Laporan kelas **{{ $report?->classRoom?->fullName }}**  belum anda kirimkan untuk diverifikasi, silahkan kirimkan sebelum batas waktu yang ditentukan

<x-mail::button :url="$url">
Ajukan Verifikasi
</x-mail::button>

Terima Kasih,<br />
{{ config('app.name') }}
</x-mail::message>
