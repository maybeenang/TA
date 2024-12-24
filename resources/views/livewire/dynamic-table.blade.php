<div
    class="relative w-full space-y-4"
    x-data="{
   @if (method_exists($this, "dialogs"))
       @foreach ($this->dialogs() as $dialog)
           {{ $dialog->model }}: false,
       @endforeach
   @endif
}"
>
    @includeWhen($this->componentBefore !== "", $this->componentBefore)

    @includeWhen($this->showSearchAndPerPage, "livewire.table.partials.entries-and-search")

    @if (session()->has("message"))
        <div class="relative mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700" role="alert">
            <span class="block sm:inline">{{ session("message") }}</span>
        </div>
    @endif

    <div class="relative overflow-x-auto">
        <table class="mb-8 mt-2 w-full table-auto border-collapse border border-zinc-300 text-left">
            <thead>
                <tr class="whitespace-nowrap uppercase">
                    @foreach ($this->columns() as $column)
                        @if ($this->numbering && $loop->first)
                            <th class="border border-zinc-300 px-2 py-2">No</th>
                        @endif

                        <th
                            scope="col"
                            @class([
                                "px-2 py-2 border border-zinc-300 ",
                                "cursor-pointer" => $column->sortable,
                            ])
                            @if ($column->sortable) wire:click="sort('{{ $column->key }}')" @endif
                        >
                            <div class="flex items-center justify-between gap-2">
                                {{ $column->label }}
                                @if ($sortBy === $column->key)
                                    @if ($sortDirection === "asc")
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
                    <tr class="align-top odd:bg-zinc-50 even:bg-white">
                        @if ($this->numbering)
                            <td class="border border-zinc-300 px-2 py-2">{{ $loop->iteration }}</td>
                        @endif

                        @foreach ($this->columns() as $column)
                            <td class="border border-zinc-300 px-2 py-2">
                                @php
                                    if (Str::contains($column->key, ".")) {
                                        $keys = explode(".", $column->key);

                                        $value = $row;

                                        foreach ($keys as $key) {
                                            $value = $value[$key];
                                            if (is_null($value)) {
                                                break;
                                            }
                                        }
                                    } elseif ($column->key === "") {
                                        $value = $row;
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
                        <td
                            class="border border-zinc-100 px-2 py-2 text-center"
                            colspan="{{ count($this->columns()) }}"
                        >
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="h-[40px]"></div>
        <div
            wire:loading.flex
            wire:target="gotoPage, nextPage, previousPage, search, perPage"
            class="absolute top-0 flex h-full w-full items-center justify-center gap-2 bg-white/20 backdrop-blur-sm"
        >
            <x-icons.loading-spinner />
            loading...
        </div>
    </div>
    {{
        $this->data()->links(
            data: [
                "scrollTo" => false,
            ],
        )
    }}

    @includeWhen($this->componentAfter !== "", $this->componentAfter)
</div>
