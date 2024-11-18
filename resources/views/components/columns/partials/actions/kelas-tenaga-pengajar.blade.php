@props([
    "value",
])

<div>
    <a href="{{ route("tenaga-pengajar.kelas.show", $value) }}" class="text-blue-500 hover:text-blue-700">Detail</a>
</div>
