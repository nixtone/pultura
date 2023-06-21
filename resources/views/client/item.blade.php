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
            <tr>
                <th>Номер</th>
                <th>Статус</th>
                <th>Принят</th>
                <th>Исполнить до</th>
            </tr>
            <tr>
                <td>12</td>
                <td>Выполняется</td>
                <td>03 май 2023 в 13:48</td>
                <td>15 июль 2023</td>
            </tr>
        </table>

</div>
@endsection
