<div class="w-full">
    <div class="overflow-x-auto">
        <div class="min-w-max">
            <table class="mb-8 mt-2 w-full table-auto border-collapse border border-zinc-300 text-left">
                <thead>
                    <tr class="whitespace-nowrap uppercase">
                        @foreach ($headers as $header)
                            <th class="border border-zinc-300 px-2 py-2">{{ $header }}</th>
                        @endforeach

                        <th class="border border-zinc-300 px-2 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->data() as $row)
                        <tr class="whitespace-nowrap align-top odd:bg-zinc-50 even:bg-white">
                            @foreach ($row as $key => $cell)
                                <td @class(["border border-zinc-300 px-2 py-2", "" => true])>{{ $cell }}</td>
                            @endforeach

                            <td class="border border-zinc-300 px-2 py-2">
                                <button @click="">edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
