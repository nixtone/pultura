@extends('design')

@section('title', 'Категория: '.$category->name)
@section('content')

    @include('product.list', $productList)

@endsection





