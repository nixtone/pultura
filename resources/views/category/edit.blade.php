@extends('design')

@section('title', 'Редакция категории: '.$category->name)
@section('content')
<div id="category" class="block">
    <form action="{{ route('catalog.category.update', $category->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="field_area">
            <label for="name">Название @error('name') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="text" name="name" id="name" class="field" value="{{ $category->name }}">
        </div>
        <div class="field_area">
            <label for="parent">Родительская категория @error('parent_id') <span class="err">{{ $message }}</span> @enderror</label>
            <select name="parent_id" id="parent" class="field">
                <option value="" @if(!$category->parent_id) selected @endif></option>
                @foreach($categoryList as $cat)
                    <option value="{{ $cat->id }}" @if($cat->id == $category->parent_id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field_area">
            <input type="submit" value="Редактировать категорию" class="btn">
        </div>
    </form>
</div>
@endsection





