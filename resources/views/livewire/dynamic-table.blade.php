<div class="space-y-4">

    <!--Entries dan Search-->
    <div class="flex justify-between">
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

    <div class="overflow-x-auto">
        <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50">
            <thead>
                <tr class="">
                    @foreach ($this->columns() as $column)
                        <th scope="col" @class([
                            'px-2 py-2 border border-zinc-100 ',
                            'cursor-pointer' => $column->sortable,
                        ])
                            @if ($column->sortable) wire:click="sort('{{ $column->key }}')" @endif>
                            <div class="flex items-center justify-between">
                                {{ $column->label }}
                                @if ($sortBy === $column->key)
                                    @if ($sortDirection === 'asc')
                                        <x-icons.up-icon />
                                    @else
                                        <x-icons.down-icon />
                                    @endif
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($this->data() as $row)
                    <tr class="odd:bg-zinc-50 even:bg-white">
                        @foreach ($this->columns() as $column)
                            <td class="px-2 py-2 border border-zinc-100">
                                @php
                                    if (gettype($column->key) == 'array') {
                                        $value = $row;
                                        foreach ($column->key as $key) {
                                            $value = $value[$key];
                                        }
                                    } else {
                                        $value = $row[$column->key];
                                    }
                                @endphp
                                <x-dynamic-component :component="$column->component" :value="$value" />
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->data()->links() }}
</div>
