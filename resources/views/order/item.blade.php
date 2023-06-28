@extends('design')

@section('title', 'Заказ: '.$order->id)
@section('content')

<div id="order" class="item block">

    <!-- <div class="pult">
        <input type="submit" value="Печать" onClick="window.print()" class="btn">
    </div> -->

    <h2>Клиент: {{ $order->client->name }}</h2>
    @include('client.inc.item', ['client' => $order->client])

    <h2>Текст для памятника</h2>
    <table class="list">
        <tr>
            <th>ФИО</th>
            <th>Дата рождения</th>
            <th>Дата смерти</th>
            <th>Эпитафия</th>
        </tr>
        <tr>
            <td>{{ $order->lastname }} {{ $order->firstname }} {{ $order->fathername }}</td>
            <td>{{ $order->birth_date }}</td>
            <td>{{ $order->death_date }}</td>
            <td>{{ $order->epitafia }}</td>
        </tr>
    </table>

    <h2>Внесенные платежи</h2>
    <table class="list">
        <tr>
            <th>Сумма</th>
            <th>Комментрий</th>
            <th>Внесено</th>
            <th colspan="2"><a href="{{ route('pay.create', $order->id) }}" class="btn new">Добавить</a></th>
        </tr>
        @if($order->pay->isEmpty())
        <tr>
            <td colspan="5" class="tac">Отсутствуют</td>
        </tr>
        @else
        @foreach($order->pay as $pay)
        <tr>
            <td class="tac">{{ $pay->amount }}</td>
            <td>{{ $pay->comment }}</td>
            <td class="tac">{{ $pay->created_at }}</td>
            <td class="tac"><a href="{{ route('pay.edit', $pay->id) }}" class="edit ico"></a></td>
            <td class="tac">
                <form action="{{ route('pay.delete', $pay->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" value="" class="delete ico">
                </form>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5">Итого: {{ $order->total_amount }} (Погашено)</td>
        </tr>
        @endif
    </table>

    {{--
    <div>
        <p>Имя клиента: <a href="/client-item">Стрельбицкая Жанна Олеговна</a></p>
        <p>Монтажные работы (чьи, где): кл. Песчаная Глинка</p>
        <p>Материал изделия: Гранит Цвет: Габбро Происхождение: Карелия</p>
    </div>

    <table class="list">
        <tr>
            <th>Принят</th>
            <th>Исполнить до</th>
            <th>Статус</th>
        </tr>
        <tr>
            <td>03 май 2023 в 13:48</td>
            <td>15 июнь 2023</td>
            <td>Выполняется</td>
        </tr>
    </table>

    <table class="list">
        <tr>
            <th>Наименования</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        <tr>
            <td>Стелла (размеры: 100х50х5) + подставка (размеры: 60х20х15)</td>
            <td>150</td>
            <td>2</td>
            <td>300</td>
        </tr>
        <tr>
            <th>Услуги</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        <tr>
            <td>Демонтаж</td>
            <td>110</td>
            <td>3</td>
            <td>330</td>
        </tr>
        <tr>
            <td colspan="4">Итого: 630</td>
        </tr>
    </table>

    <h2>Данные для памятника</h2>

    <table class="list">
        <tr>
            <td>Фамилия:</td>
            <td colspan="3">Стрельбицкая</td>
            <td rowspan="5" style="text-align: center;">
                <img src="/static/images/upload/order/1.png" alt="">
            </td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td colspan="3">Елена</td>
        </tr>
        <tr>
            <td>Отчество:</td>
            <td colspan="3">Павловна</td>
        </tr>
        <tr>
            <td>Дата рождения:</td>
            <td>13.10.1948</td>
            <td>Дата смерти:</td>
            <td>28.04.2021</td>
        </tr>
        <tr>
            <td>Эпитафия:</td>
            <td colspan="3">Ты всегда в наших сердцах</td>
        </tr>
    </table>

    <h2>Внесенные платежи</h2>

    <table class="list">
        <tr>
            <th>Сумма</th>
            <th>Комментарий</th>
        </tr>
        <tr>
            <td class="td">45</td>
            <td class="td">Аванс</td>
        </tr>
    </table>
    --}}
</div>

@endsection
