@extends('design')

@section('title', 'Список клиентов')
@section('content')
<div id="client-list" class="block">

    <form action="{{ route('client.search') }}" method="post" id="search_area">
        @csrf
        {{-- <h2>Поиск</h2> --}}
        <div class="wrap">
            <div class="field_area c1">
                <select name="category" class="field category">
                    <option value="0">Не важно</option>
                    @foreach($clientCategory as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field_area c2">
                <input type="text" name="name" id="name" class="field name presearch_field" value="{{ old('name') }}" placeholder="Поиск" autocomplete="off">
                <input type="text" name="phone" id="phone" class="field phone presearch_field phonemask" value="{{ old('phone') }}" placeholder="Поиск" autocomplete="off" style="display: none;">
                <div class="preresult"></div>
            </div>
            <div class="field_area c3">
                <select name="criterion" class="field criterion">
                    <option value="name">По фамилии И.О.</option>
                    <option value="phone">По номеру телефона</option>
                </select>
            </div>
            <div class="field_area c4">
                <input type="submit" value="Искать" class="btn">
            </div>
        </div>
    </form>

    {{--
    <div id="client_category" class="block">
        <h2>Категории клиентов</h2>
        <div class="inner">
        @foreach($clientCategory as $cat)
            <a href="{{ route('client.list') }}?cat={{ $cat->id }}" class="item @if($cat->id == request()->get('cat')) active @endif">{{ $cat->name }}</a>
        @endforeach
        </div>
    </div>
    --}}

    <table class="list">
        <tr>
            <th>Имя</th>
            <th>Телефон</th>
            <th>E-mail</th>
            <th>Категория</th>
            <th colspan="2"><a href="{{ route('client.create') }}" class="btn new">Новый клиент</a></th>
        </tr>
        @if($clientList->isEmpty())
        <tr>
            <td colspan="7" style="text-align: center">Клиентов нет</td>
        </tr>
        @else
        @foreach($clientList as $client)
        <tr>
            <td><a href="{{ route('client.item', $client->id) }}">{{ $client->name }}</a></td>
            <td class="tac">{{ $client->phone }}</td>
            <td class="tac">{{ $client->email }}</td>
            <td class="tac">@if($client->client_category)<a href="?cat={{ $client->client_category->id }}">{{ $client->client_category->name }}</a>@endif</td>
            <td class="tac">
                <a href="{{ route('client.edit', $client->id) }}" class="edit ico">
                    <img src="{{ asset('/static/images/ico/edit.svg') }}" alt="" style="width: 20px; height: 20px;">
                </a>
            </td>
            <td class="tac">
                <form action="{{ route('client.delete', $client->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <!-- <input type="submit" value="" class="delete ico"> -->
                    <button class="ico">
                        <img src="{{ asset('/static/images/ico/delete.svg') }}" alt="" style="width: 20px; height: 20px;">
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </table>

</div>
@endsection
