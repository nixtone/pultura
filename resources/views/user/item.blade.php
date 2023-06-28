@extends('design')

@section('title', 'Сотрудник: ')
@section('content')
<div id="user" class="block">

<pre>
Имя: {{ $user->name }}
Телефон: {{ $user->phone }}
Почта: {{ $user->email }}
Комментарий: {{ $user->comment }}
Группа: {{ $user->user_group }}
Создан: {{ $user->created_at }}

</pre>

</div>
@endsection
