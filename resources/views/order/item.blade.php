@extends('design')

@section('title', 'Заказ: '.$order->id)
@section('content')

<div id="order" class="item block">

    <table class="list">
        <tr>
            <th>Статус</th>
            <th>Исполнить до:</th>
            <th>Клиент</th>

        </tr>
        <tr>
            <td>
                <form action="" method="post">
                    @csrf
                    <select name="order_status" id="order_status" class="field">
                        @foreach($statusList as $status)
                        <option value="{{ $status->id }}" @if($status->id == $order->status_id) selected @endif>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </form>
            </td>
            <td class="tac">{{ $order->deadline_date_ru }}</td>
            <td class="tac"><a href="{{ route('client.item', $order->client->id) }}">{{ $order->client->name }}</a></td>
        </tr>
        <tr>
            <th colspan="3">Комментарий:</th>
        </tr>
        <tr>
            <td colspan="3">
                <div>{{ $order->comment }}</div>
            </td>
        </tr>
    </table>

    <table class="list">
        <tr>
            <td class="h2">Детали заказа</td>
        </tr>
        <tr>
            <td><?php p($order->price_list) ?></td>
        </tr>
    </table>

    <table class="list">
        <tr>
            <td class="h2">Смета</td>
        </tr>
        <tr>
            <td>{{ $order->total_correct }}</td>
        </tr>
        <tr>
            <td><?php p($order->estimate) ?></td>
        </tr>
    </table>


    <table class="list">
        <tr>
            <td colspan="2" class="h2">Платежи<a href="#" class="btn in-title invert cpp" data-pp="payment">Внести</a></td>
        </tr>
        <tr>
            <th>Сумма</th>
            <th>Комментарий</th>
        </tr>
        @foreach($paymentList as $payItem)
        <tr>
            <td class="tac">{{ $payItem['amount'] }}</td>
            <td>{{ $payItem['comment'] }}</td>
        </tr>
        @endforeach
    </table>


    {{-- dump($order) --}}

    {{--
    <table class="list">
        <tr>
            <td>Услуги</td>
            <td><?php p($order->services) ?></td>
        </tr>
        <tr>
            <td>Прайс лист</td>
            <td><?php p($order->price_list) ?></td>
        </tr>
        <tr>
            <td>Смета</td>
            <td><?php p($order->estimate) ?></td>
        </tr>
        <tr>
            <td>Корректировка</td>
            <td>{{ $order->total_correct }}</td>
        </tr>
    </table>
    --}}

</div>
@endsection
