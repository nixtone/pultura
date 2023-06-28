@extends('design')

@section('title', 'Редакция платежа к заказу: '.$pay->order_id)
@section('content')
<div id="pay" class="list block">
    <p>Перейти к заказу <a href="{{ route('order.item', $pay->order_id) }}">{{ $pay->order_id }}</a> этого платежа</p>
    <form action="{{ route('pay.update', $pay->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="field_area">
            <label for="pay_amount">Сумма @error('amount') <span class="err">{{ $message }}</span> @enderror </label>
            <input type="text" name="amount" id="pay_amount" class="field" value="{{ $pay->amount }}">
        </div>
        <div class="field_area">
            <label for="pay_comment">Комментарий @error('comment') <span class="err">{{ $message }}</span> @enderror </label>
            <input type="text" name="comment" id="pay_comment" class="field" value="{{ $pay->comment }}">
        </div>
        <p><strong>Платеж был внесен:</strong> {{ $pay->created_at }}</p>
        {{-- TODO: удобней разместить сообщение о дате и ссылку на заказ --}}
        <input type="submit" value="Редактировать платеж" class="btn">
    </form>
</div>
@endsection
