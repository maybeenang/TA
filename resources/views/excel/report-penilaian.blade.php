<table>
    <thead>
        <tr>
            @foreach ($header as $item)
            <th>
                {{ $item }}
            </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $row)
        <tr>
            @foreach ($row as $key => $cell)
            <td>
                {{ $cell }}
            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
