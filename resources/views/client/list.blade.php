@extends('design')

@section('title', 'Список клиентов')
@section('content')
<div id="" class="block">

    <table class="list">
        <tr>
            <th>Имя</th>
            <th>Телефон</th>
            <th>E-mail</th>
            <th>Адрес</th>
            <th colspan="2"><a href="{{ route('client.create') }}" class="btn new">Новый клиент</a></th>
        </tr>
        @if($clientList->isEmpty())
        <tr>
            <td colspan="7" style="text-align: center">Клиентов нет</td>
        </tr>
        @else
        @foreach($clientList as $client)
        <tr>
            <td><a href="{{ route('client.item', $client->id) }}">{{ $client->name }}</a></td>
            <td class="tac">{{ $client->phone }}</td>
            <td class="tac">{{ $client->email }}</td>
            <td>{{ $client->addr }}</td>
            <td class="tac"><a href="{{ route('client.edit', $client->id) }}" class="edit ico"></a></td>
            <td class="tac">
                <form action="{{ route('client.delete', $client->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" value="" class="delete ico">
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </table>

</div>
@endsection
