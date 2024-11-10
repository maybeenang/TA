@props([
    "value",
])

<div>
    <button class="text-amber-500 hover:underline" @click="$dispatch('open-edit-grade-scale', {id: {{ $value }}} )">
        Edit
    </button>
</div>
