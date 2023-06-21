@extends('design')

@section('title', 'Новый клиент')
@section('content')
<div id="client" class="new block">

        <form action="">
            <div class="field_area">
                <label for="client_name">Имя</label>
                <input type="text" name="name" id="client_name" class="field">
            </div>
            <div class="field_area">
                <label for="client_phone">Телефон</label>
                <input type="text" name="phone" id="client_phone" class="field phonemask">
            </div>
            <div class="field_area">
                <label for="client_phone">E-mail</label>
                <input type="text" name="email" id="client_email" class="field">
            </div>
            <div class="field_area">
                <label for="client_addr">Адрес</label>
                <textarea name="addr" id="client_addr" class="field" rows="2"></textarea>
            </div>
            <div class="field_area">
                <label for="client_comment">Комментарий</label>
                <textarea name="comment" id="client_comment" class="field" rows="3"></textarea>
            </div>
            <div class="field_area">
                <input type="submit" value="Создать клиента" class="btn">
            </div>
        </form>

</div>
@endsection
