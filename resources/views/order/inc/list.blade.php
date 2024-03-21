<table class="list">
    <tr>
        <th>Номер</th>
        <th>Статус</th>
        <th>Клиент</th>
        <th>Принят</th>
        <th>Исполнить до</th>
        <th colspan="2"><a href="{{ route('order.create') }}@if(isset($client))?client={{ $client->id }}@endif" class="btn new">Новый заказ</a></th>
    </tr>
    @if($orderList->isEmpty())
    <tr>
        <td colspan="7" class="tac">Заказов нет</td>
    </tr>
    @else
        @foreach($orderList as $order)
        <tr class="order_tr level c{{ $order->level }}">
            <td class="tac"><a href="{{ route('order.item', $order->id) }}">{{ $order->id }}</a></td>
            <td class="tac status c{{ $order->status->id }}">{{ $order->status->name }}</td>
            <td><a href="{{ route('client.item', $order->client_id) }}">{{ $order->client->name }}</a></td>
            <td class="tac">{{ $order->created_at_ru }}</td>
            <td class="tac deadline">
                <div class="date">{{ $order->deadline_date_ru }}</div>


                <div class="rest">
                    {{--
                    1 - много дней
                    2 - остается 10 дней
                    3 - сегодня
                    4 - завершено
                    --}}

                    @switch($order->level)
                        @case(3)
                            Сегодня
                        @break
                        @case(4)
                            Время истекло
                        @break
                        @default
                            Осталось дней: {{ $order->dayRest }}
                        @break
                    @endswitch
                </div>

            </td>
            {{--<td class="tac"> @if($order->status->id != 3)<a href="{{ route('order.edit', $order->id) }}" class="edit ico"></a>@endif</td> --}}
            <td class="tac" colspan="2">
                @if(Auth::user()->user_group <= 2)
                <form action="{{ route('order.delete', $order->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" value="" class="delete ico">
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    @endif
</table>

