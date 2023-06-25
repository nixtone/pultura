@extends('design')

@section('title', 'Редакция товара')
@section('content')
    <div class="block">
        <form action="" method="post">
            @csrf
            <div class="field_area">
                <label for="name">Название</label>
                <input type="text" name="name" id="name" class="field" value="{{ $product->name }}">
            </div>
            <div class="field_area">
                <label for="price">Цена</label>
                <input type="text" name="price" id="price" class="field" value="{{ $product->price }}">
            </div>
            <div class="field_area">
                <label for="category_id">Категория</label>
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
