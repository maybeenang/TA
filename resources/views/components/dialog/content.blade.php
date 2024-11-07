<dialog
    wire:ignore.self
    x-effect="dialogOpen ? $el.showModal() : $el.close()"
    x-on:close.stop="dialogOpen = false"
    x-on:cancel.stop="dialogOpen = false"
    {{ $attributes->twMerge("w-full max-w-lg overflow-hidden text-wrap border bg-background p-6 shadow-lg  sm:rounded-lg transition-[translate,opacity,scale,overlay,display] [transition-behavior:allow-discrete] open:animate-in open:fade-in-0 open:zoom-in-95 animate-out duration-200 fade-out-0 zoom-out-95 backdrop:bg-black/80 backdrop:duration-300 backdrop:opacity-0 backdrop:transition-[opacity,display,overlay] backdrop:[transition-behavior:allow-discrete] open:backdrop:opacity-100 [@starting-style]:open:backdrop:opacity-0") }}
>
    {{ $slot }}

    <x-button class="absolute right-0 top-0" variant="ghost" @click="$dispatch('close-modal') ">
        <x-lucide-x class="size-4" />
        <span class="sr-only">Close</span>
    </x-button>
</dialog>
