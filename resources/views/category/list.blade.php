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
                @if(!$category->parent_id)
                    @include('category.inc.item', ['child' => false])
                    @foreach($categoryList as $category2)
                        @if($category->id == $category2->parent_id)
                            @include('category.inc.item', ['category' => $category2, 'child' => true])
                        @endif
                    @endforeach
                @endif
                {{--
                @if($category->children)
                    @include('category.inc.item', ['child' => true])
                @else
                    @include('category.inc.item', ['child' => true])
                @endif
                --}}
            @endforeach

        @endif
    </table>

@endsection
