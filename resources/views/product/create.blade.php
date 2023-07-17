@extends('design')

@section('title', 'Новый товар')
@section('content')
<div class="block">
    <form action="{{ route('catalog.product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="field_area">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="field">
        </div>
        <div class="field_area">
            <label for="price">Цена</label>
            <input type="text" name="price" id="price" class="field" value="0">
        </div>
        <div class="field_area">
            <label for="category_id">Категория</label>
            <select name="category_id" id="category_id" class="field">
                @foreach($categoryList as $cat)
                <option value="{{ $cat->id }}" @if($cat->id == $category->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field_area">
            <label for="files">Изображение товара</label>
            <input type="file" name="files[]" id="files" class="field" multiple accept="image/*">
        </div>
        <div class="field_area">
            <input type="submit" value="Создать товар" class="btn">
        </div>
    </form>
</div>
@endsection
