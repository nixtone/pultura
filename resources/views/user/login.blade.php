<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/ico" href="{{ asset('/favicon.ico') }}">
<title>Вход</title>
<style>
@font-face {
    font-family: 'Open Sans';
    src: url('{{ asset('/static/fonts/opensans/OpenSans-Extrabold.woff2') }}') format('woff2');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Open Sans';
    src: url('{{ asset('/static/fonts/opensans/OpenSans-Bold.woff2') }}') format('woff2');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Open Sans';
    src: url('{{ asset('/static/fonts/opensans/OpenSans.woff2') }}') format('woff2');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}

html, body {
    height: 100%;
}
body {
    display: flex;
    flex-direction: column;
    margin: 0;
    font-family: 'Open Sans';
    font-size: 0.8rem;
}

.field_group {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #bcbcbc;
}
.field_group .field_area:first-child {
    margin-top: 0;
}
.field_group .field_area:last-child {
    margin-bottom: 0;
}
.field_group h2 {
    background: #122b45;
    color: #f9feff;
    margin: -11px;
    padding: 6px 10px 8px;
    margin-bottom: 10px;
    font-size: 1.2em;
}
form .field_area:first-child {
    margin-top: 0;
}
.field_area {
    margin: 10px 0;
}
.field_area label {
    display: block;
    margin-bottom: 5px;
}
.field_area .field {
    display: block;
    padding: 5px 6px 6px;
    box-sizing: border-box;
    width: 100%;
}
.field_area.inline label {
    display: inline;
}

.btn {
    padding: 7px 10px 9px;
    display: block;
    text-decoration: none;
    background: #dcf0e7;
    border-radius: 2px;
    border: 0;
    cursor: pointer;
    transition: .3s;
    text-align: center;
}
.btn:hover {
    background: #b8dfcd;
    text-decoration: none;
}

.auth_area {
    margin: auto;
    max-width: 320px;
    width: 100%;
}

.err {
    margin: 15px 0 10px;
    color: #ff0000;
}
</style>
</head>
<body>

<div class="auth_area">
    <form action="{{ route('user.login') }}" method="post">
        @csrf
        <div class="field_group">
            <h2>Вход в CRM</h2>
            <div class="field_area">
                <label for="name">Логин</label>
                <input type="text" name="name" id="name" class="field">
                @error('name')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field_area">
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" class="field">
                @error('password')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field_area inline">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Запомнить меня</label>
            </div>
            <div class="field_area">
                <input type="submit" value="Войти" class="btn">
                @error('formError')<div class="err">{{ $message }}</div>@enderror
            </div>
        </div>
    </form>
</div>

</body>
</html>
