@extends('design')

@section('title', 'Редакция товара: '.$product->name)
@section('content')
<div id="product" class="block">
    <form action="{{ route('catalog.product.update', $product->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="field_area">
            <label for="name">Название @error('name') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="text" name="name" id="name" class="field" value="{{ $product->name }}">
        </div>
        <div class="field_area">
            <label for="price">Цена @error('price') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="text" name="price" id="price" class="field" value="{{ $product->price }}">
        </div>
        <div class="field_area">
            <label for="category_id">Категория @error('category_id') <span class="err">{{ $message }}</span> @enderror</label>
            <select name="category_id" id="category_id" class="field">
                @foreach($categoryList as $cat)
                    <option value="{{ $cat->id }}" @if($cat->id == $product->category->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field_area">
            <input type="submit" value="Создать товар" class="btn">
        </div>
    </form>
</div>
@endsection
