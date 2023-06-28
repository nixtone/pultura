@extends('design')

@section('title', 'Новый сотрудник')
@section('content')
<div id="user" class="block">
    <form action="{{ route('user.save') }}" method="post">
        @csrf
        <div class="field_area">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" class="field">
        </div>
        <div class="field_area">
            <label for="phone">Телефон</label>
            <input type="text" name="phone" id="phone" class="field phonemask">
        </div>
        <div class="field_area">
            <label for="email">E-mail</label>
            <input type="text" name="email" id="email" class="field">
        </div>
        <div class="field_area">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" class="field">
        </div>
        <div class="field_area">
            <label for="password_retype">Повторите пароль</label>
            <input type="password" name="password_retype" id="password_retype" class="field">
        </div>
        <div class="field_area">
            <label for="comment">Комментарий</label>
            <textarea name="comment" id="comment" rows="3" class="field"></textarea>
        </div>
        <div class="field_area">
            <label for="user_group">Группа доступа</label>
            <select name="user_group" id="user_group" class="field">
                <option value="1" selected>Пользователь</option>
                <option value="2">Администратор</option>
            </select>
        </div>
        <div class="field_area">
            <input type="submit" value="Зарегестрировать" class="btn">
        </div>
    </form>
</div>
@endsection
