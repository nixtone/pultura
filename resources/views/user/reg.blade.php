@extends('design')

@section('title', 'Новый сотрудник')
@section('content')
<div id="user" class="block">
    <form action="{{ route('user.save') }}" method="post">
        @csrf
        <div class="field_area">
            <label for="name">Имя @error('name') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="text" name="name" id="name" class="field" value="{{ old('name') }}">
        </div>
        <div class="field_area">
            <label for="phone">Телефон @error('phone') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="text" name="phone" id="phone" class="field phonemask" value="{{ old('phone') }}">
        </div>
        <div class="field_area">
            <label for="email">E-mail @error('email') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="email" name="email" id="email" class="field" value="{{ old('email') }}">
        </div>
        <div class="field_area">
            <label for="password">Пароль @error('password') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="password" name="password" id="password" class="field">
        </div>
        <div class="field_area">
            <label for="password_retype">Повторите пароль @error('password_retype') <span class="err">{{ $message }}</span> @enderror</label>
            <input type="password" name="password_retype" id="password_retype" class="field">
        </div>
        <div class="field_area">
            <label for="comment">Комментарий @error('comment') <span class="err">{{ $message }}</span> @enderror</label>
            <textarea name="comment" id="comment" rows="3" class="field">{{ old('comment') }}</textarea>
        </div>
        <div class="field_area">
            <div>{{ old('user_group') }}</div>
            <label for="user_group">Группа доступа @error('user_group') <span class="err">{{ $message }}</span> @enderror</label>
            <select name="user_group" id="user_group" class="field">
                @foreach($userGroupList as $userGroup)
                <option value="{{ $userGroup->id }}" @if(old('user_group') == $userGroup->id) selected @endif>{{ $userGroup->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field_area">
            <input type="submit" value="Зарегестрировать" class="btn">
        </div>
    </form>
</div>
@endsection
