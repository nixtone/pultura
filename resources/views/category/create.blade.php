@extends('design')

@section('title', 'Новая категория')
@section('content')

<div id="category" class="block">
    <form action="{{ route('catalog.category.store') }}" method="post">
        @csrf
        <div class="field_area">
            <label for="name">Название @error('name') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="text" name="name" id="name" class="field">
        </div>
        <div class="field_area">
            <label for="parent">Родительская категория @error('parent_id') <span class="err">{{ $message }}</span> @enderror</label>
            <select name="parent_id" id="parent" class="field">
                <option value="0" selected></option>
                @foreach($categoryList as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field_area">
            <input type="submit" value="Создать категорию" class="btn">
        </div>
    </form>
</div>

@endsection





