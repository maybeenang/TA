<div class="space-y-4">

    @includeWhen($this->componentBefore !== '', $this->componentBefore)

    @include('livewire.table.partials.entries-and-search')

    <div class="overflow-x-auto">
        <table class="table-auto w-full whitespace-nowrap text-left border-collapse border border-zinc-50">
            <thead>
                <tr class="uppercase">
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
                                @elseif ($column->sortable)
                                    <x-icons.up-down-icon />
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($this->data() as $row)
                    <tr class="odd:bg-zinc-50 even:bg-white align-top">
                        @foreach ($this->columns() as $column)
                            <td class="px-2 py-2 border border-zinc-100">
                                @php
                                    if (Str::contains($column->key, '.')) {
                                        $keys = explode('.', $column->key);

                                        $value = $row;

                                        foreach ($keys as $key) {
                                            $value = $value[$key];
                                            if (is_null($value)) {
                                                break;
                                            }
                                        }
                                    } else {
                                        $value = $row[$column->key];
                                    }

                                @endphp
                                <x-dynamic-component :component="$column->component" :value="$value" />
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td class="px-2 py-2 border border-zinc-100 text-center" colspan="{{ count($this->columns()) }}">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $this->data()->links() }}
</div>
