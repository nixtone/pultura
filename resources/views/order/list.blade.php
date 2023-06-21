@extends('design')

@section('title', 'Список заказов')
@section('content')
<div id="order" class="list block">

    <div class="pult">
        <a href="{{ route('order.create') }}" class="btn new">Новый заказ</a>
    </div>

    <table class="list">
        <tr class="title">
            <th>Номер</th>
            <th>Статус</th>
            <th>Клиент</th>
            <th>Принят</th>
            <th>Исполнить до</th>
            <th></th>
            <th></th>
        </tr>
        @if($orderList->isEmpty())
        <tr>
            <td colspan="7" style="text-align: center">Заказов нет</td>
        </tr>
        @else
        @foreach($orderList as $order)
        <tr>
            <td><a href="{{ route('order.item', $order->id) }}">{{ $order->id }}</a></td>
            <td>{{ $order->status->name }}</td>
            <td><a href="{{ route('client.item', $order->client_id) }}">{{ $order->client->name }}</a></td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->deadline_date }}</td>
            <td><a href="{{ route('order.edit', $order->id) }}">Редактировать</a></td>
            <td><a href="">Удалить</a></td>
        </tr>
        @endforeach
        @endif
    </table>

</div>
@endsection
