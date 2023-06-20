<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('static/custom.css') }}">
</head>
<body>
<div id="wrapper">

    <header>
        <div class="container">
            <a href="{{ route('home') }}" id="logo"><img src="{{ asset('static/images/logo.png') }}" alt="" class="bimg" style="width: 36px;"></a>
            <nav>
                <a href="/" class="active">Заказы</a>
                <a href="/client-list">Клиенты</a>
                <a href="/product-list">Услуги и наименования</a>
                <a href="/personal">Сотрудники</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1>@yield('title')</h1>
        @yield('content')
    </div>

</div>
<footer>
    <div class="container">&copy; CRM памятники <?=date('Y')?></div>
</footer>

<div class="overlay" style="display: none;">
    <div class="popup">
        <div class="close"></div>
        <div class="inner">

            <form method="post" class="callback" style="display: none;">
                <input type="text" name="NAME" placeholder="Ваше имя">
                <input type="text" name="PHONE" placeholder="Телефон">
                <input type="text" name="EMAIL" placeholder="E-mail">
                <input type="submit" value="Отправить">
            </form>

            <div class="cross" style="display: none;">
                {{--
                <img src="{{ asset('static/images/upload/1.png') }}" alt="" class="bimg preview" data-value="1">
                <img src="{{ asset('static/images/upload/2.png') }}" alt="" class="bimg preview" data-value="2">
                <img src="{{ asset('static/images/upload/3.png') }}" alt="" class="bimg preview" data-value="3">
                <img src="{{ asset('static/images/upload/4.png') }}" alt="" class="bimg preview" data-value="4">
                <img src="{{ asset('static/images/upload/5.png') }}" alt="" class="bimg preview" data-value="5">
                <img src="{{ asset('static/images/upload/6.png') }}" alt="" class="bimg preview" data-value="6">
                --}}
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('static/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('static/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('static/custom.js') }}"></script>
</body>
</html>
