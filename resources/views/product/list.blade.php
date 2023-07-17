@extends('design')

@section('title', 'Товары')
@section('content')
<div id="product" class="list block">

    <table class="list">
        <tr>
            <th>Превью</th>
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
            <td class="preview_area">

                @foreach($product->files as $file)
                    <a href="{{ asset($file) }}" data-fancybox="gallery">
                        <img src="{{ asset($file) }}" alt="" class="preview bimg">
                    </a>
                @endforeach
                {{--
                @foreach($product->image as $image)
                    <a href="{{ asset('/storage/images/products/'.$image) }}" data-fancybox="gallery">
                        <img src="{{ asset('/storage/images/products/'.$image) }}" alt="" class="preview bimg">
                    </a>
                @endforeach
                --}}
            </td>
            <td><a href="{{ route('catalog.product.item', $product->id) }}">{{ $product->name }}</a></td>
            <td class="tac">{{ $product->price }}</td>
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
</div>
@endsection
