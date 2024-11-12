<div class="flex flex-col md:flex-row md:justify-between">
    <div class="flex items-center gap-2">
        <x-label htmlFor="perPage">Show</x-label>
        <x-select class="w-[75px]" id="perPage" wire:model.live="perPage">
            <option value="10">10</option>
            <option value="20">20</option>
        </x-select>
        <x-label htmlFor="perPage">Entries</x-label>
    </div>
    <div class="flex items-center gap-2">
        <x-label htmlFor="tahun-ajaran">Search</x-label>
        <x-input wire:model.live.debounce.500ms="search" />
    </div>
</div>
