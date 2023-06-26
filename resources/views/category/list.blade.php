@extends('design')

@section('title', 'Каталог')
@section('content')

    <table class="list">
        <tr>
            <th>Категория</th>
            <th colspan="2"><a href="{{ route('catalog.category.new') }}" class="btn new">Новая категория</a></th>
        </tr>
        @if($categoryList->isEmpty())
            <tr>
                <td colspan="4" style="text-align: center">Категорий нет</td>
            </tr>
        @else
        @foreach($categoryList as $category)
        <tr>
            <td><a href="{{ route('catalog.category.item', $category->id) }}">{{ $category->name }}</a></td>
            <td class="tac"><a href="{{ route('catalog.category.edit', $category->id) }}" class="edit ico"></a></td>
            <td class="tac">
                <form action="{{ route('catalog.category.delete', $category->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" value="" class="delete ico">
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </table>

@endsection





