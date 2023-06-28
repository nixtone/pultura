@extends('design')

@section('title', 'Новый платеж к заказу: '.$order)
@section('content')
<div id="pay" class="list block">
    <form action="{{ route('pay.store') }}" method="post">
        @csrf
        <div class="field_area">
            <label for="amount">Сумма</label>
            <input type="text" name="amount" id="amount" class="field">
        </div>
        <div class="field_area">
            <label for="comment">Комментарий</label>
            <textarea name="comment" id="comment" rows="3" class="field"></textarea>
        </div>
        <input type="hidden" name="order_id" value="{{ $order }}">
        <input type="submit" value="Добавить платеж" class="btn">
    </form>
</div>
@endsection
