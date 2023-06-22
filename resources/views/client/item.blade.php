@extends('design')

@section('title', 'Клиент: '.$client->name)
@section('content')
<div id="" class="block">

    @include('client.inc.item')

    <h2>Заказы клиента</h2>
    {{--  TODO: вывод в обратном порядке  --}}
    @include('order.inc.list', ['orderList' => $client->orders])

</div>
@endsection
