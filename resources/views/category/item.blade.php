@extends('design')

@section('title', 'Категория: '.$category->name)
@section('content')

    @include('product.list', ['productList' => $category->product, 'category_id' => $category->id])

@endsection





