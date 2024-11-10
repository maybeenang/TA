@props([
    "value",
])

<div class="">
    <button class="text-amber-500 hover:underline" @click="$dispatch('open-edit-presensi', {id: {{ $value }}} )">
        Edit
    </button>
</div>
