@extends('design')

@section('title', 'Список наименований и услуг')
@section('content')
    <div id="" class="block">

        <div class="pult">
            <a href="{{ route('product.create') }}" class="btn new">Новый товар или услуга</a>
        </div>

        <table class="list">
            <tr>
                <th>Название</th>
                <th>Тип</th>
                <th>Категория</th>
                <th>Цена</th>
            </tr>
            @if($productList->isEmpty())
            <tr>
                <td colspan="5" style="text-align: center">Товаров или услуг нет</td>
            </tr>
            @else
            @foreach($productList as $product)
            <tr>
                <td><a href="{{ route('product.item', $product->id) }}">{{ $product->name }}</a></td>
                <td>{{ $product->type }}</td>
                <td>{{ $product->product_category_id }}</td>
                <td>{{ $product->price }}</td>
            </tr>
            @endforeach
            @endif
        </table>

    </div>
@endsection
