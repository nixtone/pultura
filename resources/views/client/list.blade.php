@extends('design')

@section('title', 'Список клиентов')
@section('content')
<div id="" class="block">

    <div id="client_category" class="block">
        <h2>Категории клиентов</h2>
        <div class="inner">
        @foreach($clientCategory as $cat)
            <a href="?cat={{ $cat->id }}" class="item @if($cat->id == request()->get('cat')) active @endif">{{ $cat->name }}</a>
        @endforeach
        </div>
    </div>

    <table class="list">
        <tr>
            <th>Имя</th>
            <th>Телефон</th>
            <th>E-mail</th>
            <th>Категория</th>
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
            <td class="tac">@if($client->client_category)<a href="?cat={{ $client->client_category->id }}">{{ $client->client_category->name }}</a>@endif</td>
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
