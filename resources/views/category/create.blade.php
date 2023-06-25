@extends('design')

@section('title', 'Новая категория')
@section('content')

<div id="category" class="block">
    <form action="" method="post">
        @csrf
        <div class="field_area">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="field">
        </div>
        <div class="field_area">
            <label for="parent">Родительская категория</label>
            <select name="parent_id" id="parent" class="field">
                @foreach($categoryList as $cat)
                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field_area">
            <input type="submit" value="Создать категорию" class="btn">
        </div>
    </form>
</div>

@endsection





