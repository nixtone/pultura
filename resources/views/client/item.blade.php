@extends('design')

@section('title', 'Клиент: '.$client->name)
@section('content')
<div id="" class="block">

<pre>
Телефон: {{ $client->phone }}
E-mail: {{ $client->email }}
Адрес: {{ $client->addr }}
Комментарий: {{ $client->comment }}
</pre>

    <h2>Заказы клиента</h2>
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
        @if($client->orders->isEmpty())
        <tr>
            <td colspan="7" style="text-align: center">Заказов нет</td>
        </tr>
        @else
        @foreach($client->orders as $order)
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

        {{--
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
        --}}
    </table>

</div>
@endsection
