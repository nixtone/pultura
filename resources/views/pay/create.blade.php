@extends('design')

@section('title', 'Новый платеж по заказу: '.$order)
@section('content')
    <div id="pay" class="list block">

        <form action="">

            <input type="submit" value="Добавить платеж к заказу: {{ $order }}">
        </form>

    </div>
@endsection
