@extends('design')

@section('title', 'Список сотрудников')
@section('content')
<div id="user" class="block">
    <table class="list">
        <tr>
            <th>Логин</th>
            <th>Телефон</th>
            <th>E-mail</th>
            <th>Группа</th>
            <th>Создан</th>
            <th colspan="2"><a href="{{ route('user.reg') }}" class="btn new">Новый сотрудник</a></th>
        </tr>
        @foreach($userList as $user)
        <tr>
            <td><a href="{{ route('user.item', $user->id) }}">{{ $user->name }}</a></td>
            <td class="tac">{{ $user->phone }}</td>
            <td class="tac">{{ $user->email }}</td>
            <td class="tac">{{ $user->user_group }}</td>
            <td class="tac">{{ $user->created_at }}</td>
            <td class="tac"><a href="{{ route('user.edit', $user->id) }}" class="edit ico"></a></td>
            <td class="tac">
                <form action="{{ route('user.delete', $user->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" value="" class="delete ico">
                </form>
            </td>
        </tr>
        @endforeach
{{--
        @if($orderList->isEmpty())
            <tr>
                <td colspan="7" class="tac">Заказов нет</td>
            </tr>
        @else
            @foreach($orderList as $order)
                <tr>
                    <td class="tac"><a href="{{ route('order.item', $order->id) }}">{{ $order->id }}</a></td>
                    <td class="tac">{{ $order->status->name }}</td>
                    <td><a href="{{ route('client.item', $order->client_id) }}">{{ $order->client->name }}</a></td>
                    <td class="tac">{{ $order->created_at }}</td>
                    <td class="tac">{{ $order->deadline_date }}</td>
                    <td class="tac"><a href="{{ route('order.edit', $order->id) }}" class="edit ico"></a></td>
                    <td class="tac">
                        <form action="{{ route('order.delete', $order->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" value="" class="delete ico">
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        --}}
    </table>
</div>
@endsection

