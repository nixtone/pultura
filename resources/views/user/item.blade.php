@extends('design')

@section('title', 'Сотрудник: ')
@section('content')
<div id="user" class="block">

    <table class="list">
        <tr>
            <th>Имя</th>
            <th>Телефон</th>
            <th>E-mail</th>
            <th>Группа</th>
            <th>Создан</th>
            <th><a href="{{ route('user.logout') }}" class="btn new">Выход</a></th>
        </tr>
        <tr>
            <td>{{ $user->name }}</td>
            <td class="tac">{{ $user->phone }}</td>
            <td class="tac">{{ $user->email }}</td>
            <td class="tac">{{ $user->user_group }}</td>
            <td class="tac">{{ $user->created_at }}</td>
            <td class="tac"><a href="{{ route('user.edit', $user->id) }}" class="edit ico"></a></td>
        </tr>
        @if($user->comment)
        <tr>
            <td colspan="6">
                <div><strong>Комментарий:</strong> {{ $user->comment }}</div>
            </td>
        </tr>
        @endif
    </table>

</div>
@endsection
