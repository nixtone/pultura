@extends('design')

@section('title', 'Каталог')
@section('content')

    <table class="list">
        <tr>
            <th>Категория</th>
            <th colspan="2"><a href="{{ route('catalog.category.new') }}" class="btn new">Новая категория</a></th>
        </tr>
        @foreach($catList as $cat)
        <tr>
            <td><a href="{{ route('catalog.category.item', $cat->id) }}">{{ $cat->name }}</a></td>
            <td class="tac"><a href="{{ route('catalog.category.edit', $cat->id) }}" class="edit ico"></a></td>
            <td class="tac">
                <form action="{{-- route('client.delete', $client->id) --}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" value="" class="delete ico">
                </form>
            </td>
        </tr>
        @endforeach
    </table>

@endsection





