<table class="list">
    <tr>
        <th>Номер</th>
        <th>Статус</th>
        <th>Клиент</th>
        <th>Принят</th>
        <th>Исполнить до</th>
        <th colspan="2"><a href="{{ route('order.create') }}" class="btn new">Новый заказ</a></th>
    </tr>
    @if($orderList->isEmpty())
    <tr>
        <td colspan="7" class="tac">Заказов нет</td>
    </tr>
    @else
        @foreach($orderList as $order)
        <tr>
            <td class="tac"><a href="{{ route('order.item', $order->id) }}">{{ $order->id }}</a></td>
            <td class="tac">{{ $order->status->name }}</td>
            <td><a href="{{ route('client.item', $order->client_id) }}">{{ $order->client->name }}</a></td>
            <td class="tac">{{ $order->created_at }}</td>
            <td class="tac">{{ $order->deadline_date }}</td>
            <td class="tac"><a href="{{ route('order.edit', $order->id) }}" class="edit ico"></a></td>
            <td class="tac"><a href="" class="delete ico"></a></td>
        </tr>
        @endforeach
    @endif
</table>

