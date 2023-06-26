@extends('design')

@section('title', 'Товары')
@section('content')
    <div id="" class="block">

        <table class="list">
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th colspan="2"><a href="{{ route('catalog.product.create', $category) }}" class="btn new">Новый товар</a></th>
            </tr>
            @if($productList->isEmpty())
                <tr>
                    <td colspan="4" style="text-align: center">Товаров нет</td>
                </tr>
            @else
            @foreach($productList as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td class="tac"><a href="{{ route('catalog.product.edit', $product->id) }}" class="edit ico"></a></td>
                <td class="tac">
                    <form action="{{ route('catalog.product.delete', $product->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="" class="delete ico">
                    </form>
                </td>
            </tr>
            @endforeach
            @endif
        </table>

        {{--
        <table class="list">
            <tr>
                <th>категория</th>
                <th colspan="2"><a href="{{ route('client.create') }}" class="btn new">Новая категория</a></th>
            </tr>
            @foreach($catList as $cat)
                <tr>
                    <td><a href="{{ route('catalog.category.item', $cat->id) }}">{{ $cat->name }}</a></td>
                    <td class="tac"><a href="{{ route('catalog.category.item', $cat->id) }}" class="edit ico"></a></td>
                    <td class="tac">
                        <form action="{{ route('client.delete', $client->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" value="" class="delete ico">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        --}}

    </div>
@endsection
