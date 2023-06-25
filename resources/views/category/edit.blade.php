@extends('design')

@section('title', 'Редакция категории: '.$category->name)
@section('content')

<div id="category" class="block">
    <form action="" method="post">
        @csrf
        <div class="field_area">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="field" value="{{ $category->name }}">
        </div>
        <div class="field_area">
            <label for="parent">Родительская категория</label>
            <select name="parent_id" id="parent" class="field">
                <option value="" @if(!$category->parent_id) selected @endif></option>
                @foreach($categoryList as $cat)
                    <option value="{{ $cat->name }}" @if($cat->id == $category->parent_id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field_area">
            <input type="submit" value="Редактировать категорию" class="btn">
        </div>
    </form>
</div>

@endsection





