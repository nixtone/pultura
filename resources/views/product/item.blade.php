@extends('design')

@section('title', "Товар: ".$product->name)
@section('content')
<div id="product" class="item block">
    <div class="preview_area">
        @foreach($product->files as $file)
            <a href="{{ asset($file) }}" data-fancybox="gallery" class="preview_wrap">
                <img src="{{ asset($file) }}" alt="" class="preview bimg">
            </a>
        @endforeach
    </div>
    <div class="price">Цена: {{ $product->price }}</div>
    <a href="{{ route('catalog.product.edit', $product->id) }}" class="edit ico"></a>
    <form action="{{ route('catalog.product.delete', $product->id) }}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="" class="delete ico">
    </form>
</div>
@endsection
