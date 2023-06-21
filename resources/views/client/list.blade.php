@extends('design')

@section('title', 'Список клиентов')
@section('content')
<div id="" class="block">

    <div class="pult">
        <a href="{{ route('client.create') }}" class="btn new">Новый клиент</a>
    </div>

    <table class="list">
        <tr>
            <th>Имя</th>
            <th>Телефон</th>
            <th>E-mail</th>
            <th>Адрес</th>
            <th></th>
            <th></th>
        </tr>
        @if($clientList->isEmpty())
        <tr>
            <td colspan="7" style="text-align: center">Клиентов нет</td>
        </tr>
        @else
        @foreach($clientList as $client)
        <tr>
            <td><a href="{{ route('client.item', $client->id) }}">{{ $client->name }}</a></td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->addr }}</td>
            <td><a href="{{ route('client.edit', $client->id) }}" class="btn">Редактировать</a></td>
            <td>
                <form action="{{ route('client.delete', $client->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" value="Удалить" class="btn">
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </table>

</div>
@endsection