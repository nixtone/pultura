@extends('design')

@section('title', 'Новый клиент')
@section('content')
<div id="client" class="new block">

        <form action="{{ route('client.store') }}" method="post">
            @csrf
            <div class="field_area">
                <label for="client_name">Имя@error('name') <span class="err">{{ $message }}</span>@enderror</label>
                <input type="text" name="name" id="client_name" class="field" value="{{ old('name') }}">
            </div>
            <div class="field_area">
                <label for="client_phone">Телефон@error('phone') <span class="err">{{ $message }}</span>@enderror</label>
                <input type="text" name="phone" id="client_phone" class="field phonemask" value="{{ old('phone') }}">
            </div>
            <div class="field_area">
                <label for="client_phone">E-mail @error('email') <span class="err">{{ $message }}</span> @enderror</label>
                <input type="text" name="email" id="client_email" class="field" value="{{ old('email') }}">
            </div>
            <div class="field_area">
                <label for="client_addr">Адрес</label>
                <textarea name="addr" id="client_addr" class="field" rows="2">{{ old('addr') }}</textarea>
            </div>
            <div class="field_area">
                <label for="client_comment">Комментарий</label>
                <textarea name="comment" id="client_comment" class="field" rows="3">{{ old('comment') }}</textarea>
            </div>
            <div class="field_area">
                <input type="submit" value="Создать клиента" class="btn">
            </div>
        </form>

</div>
@endsection
