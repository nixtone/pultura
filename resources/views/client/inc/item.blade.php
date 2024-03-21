<table class="list">
    <tr>
        <th>Телефон</th>
        <th>Категория</th>
        <th>E-mail</th>
        <th>Адрес</th>
        <th class="tac">@if(Auth::user()->user_group <= 2)<a href="{{ route('client.edit', $client->id) }}" class="edit ico"></a>@endif</th>
        <th class="tac">
            @if(Auth::user()->user_group <= 2)
            <form action="{{ route('client.delete', $client->id) }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" value="" class="delete ico">
            </form>
            @endif
        </th>
    </tr>
    <tr>
        <td>{{ $client->phone }}</td>
        <td>{{ $client->client_category->name }}</td>
        <td>{{ $client->email }}</td>
        <td colspan="3">{{ $client->addr }}</td>
    </tr>
    <tr>
        <td colspan="6"><strong>Комментарий:</strong> {{ $client->comment }}</td>
    </tr>
</table>
