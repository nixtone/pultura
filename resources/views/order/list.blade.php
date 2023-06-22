@extends('design')

@section('title', 'Список заказов')
@section('content')
<div id="order" class="list block">

    @include('order.inc.list')

</div>
@endsection
