<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/ico" href="{{ asset('/favicon.ico') }}">
<title>@yield('title')</title>
<link rel="stylesheet" href="{{ asset('/static/custom.css') }}">
<link rel="stylesheet" href="{{ asset('/static/fancy/jquery.fancybox.min.css') }}">
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

@if(Route::is('order.create'))
@font-face {
    font-family: 'AcademyC';
    src: url('/static/fonts/constructor/AcademyC.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'AnastasiaScript';
    src: url('/static/fonts/constructor/AnastasiaScript.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Arial';
    src: url('/static/fonts/constructor/Arial-BoldMT.woff2') format('woff2');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Asessor';
    src: url('/static/fonts/constructor/Asessor.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Carolina';
    src: url('/static/fonts/constructor/Carolina.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Times New Roman';
    src: url('/static/fonts/constructor/TimesNewRomanPS-BoldMT.woff2') format('woff2');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Times New Roman';
    src: url('/static/fonts/constructor/TimesNewRomanPS-BoldItalicMT.woff2') format('woff2');
    font-weight: bold;
    font-style: italic;
    font-display: swap;
}
@font-face {
    font-family: 'CyrillicOld';
    src: url('/static/fonts/constructor/CyrillicOld.woff2') format('woff2');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}
@endif
</style>
</head>
<body>
<div id="wrapper">

    <header>
        <div class="container">
            <div class="col c1">
                <a href="{{ route('home') }}" id="logo"><img src="{{ asset('/static/images/logo.png') }}" alt="" class="bimg" style="width: 36px;"></a>
                <nav>
                    <a href="{{ route('home') }}" class="@if(str_contains(Route::currentRouteName(), "order.")) active @endif">Заказы</a>
                    @if(Auth::user()->user_group <= 2)
                    <a href="{{ route('client.list') }}" class="@if(str_contains(Route::currentRouteName(), "client.")) active @endif">Клиенты</a>
                    <a href="{{ route('catalog.category.list') }}" class="@if(str_contains(Route::currentRouteName(), "catalog.")) active @endif">Каталог</a>
                    <a href="{{ route('user.list') }}" class="@if(str_contains(Route::currentRouteName(), "user.")) active @endif">Сотрудники</a>
                    <a href="{{ route('help') }}" class="@if(str_contains(Route::currentRouteName(), "help")) active @endif">Справка</a>
                    @endif
                </nav>
            </div>
            <div class="col c2 user_area">
                <a href="{{ route('user.item', Auth::user()->id) }}" class="name">{{ Auth::user()->name }}</a>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>@yield('title')</h1>
        @yield('content')
    </div>

</div>
<footer>
    <div class="container">CRM 2023 — <?=date('Y')?></div>
</footer>



<script src="{{ asset('/static/js/jquery.min.js') }}"></script>
<script src="{{ asset('/static/js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('/static/fancy/jquery.fancybox.min.js') }}"></script>

<!-- Заказ -->
@if(Route::is('order.create'))
<div class="overlay" style="display: none;">
    <div class="popup">
        <div class="close"></div>
        <div class="inner">
            @include('order.inc.window', ['title' => 'Модели памятников', 'field' => 'model', 'parent_cat' => 1, 'displayName' => 0, 'constructor' => 'image'])
            @include('order.inc.window', ['title' => 'Материал', 'field' => 'material', 'parent_cat' => 4, 'displayName' => 1, 'constructor' => 'back'])
            @include('order.inc.window', ['title' => 'Портрет', 'field' => 'portrait', 'parent_cat' => 7, 'displayName' => 1, 'constructor' => 'image'])
            @include('order.inc.window', ['title' => 'Гравировка', 'field' => 'grave', 'parent_cat' => 10, 'displayName' => 1, 'constructor' => 'image'])
            @include('order.inc.window', ['title' => 'Цветник / надгробие', 'field' => 'tombstone', 'parent_cat' => 17, 'displayName' => 1, 'constructor' => 'blank'])
            @include('order.inc.window', ['title' => 'Ограда', 'field' => 'fence', 'parent_cat' => 18, 'displayName' => 1, 'constructor' => 'blank'])
            @include('order.inc.window', ['title' => 'Вазы', 'field' => 'vase', 'parent_cat' => 19, 'displayName' => 1, 'constructor' => 'blank'])
        </div>
    </div>
</div>
<script src="{{ asset('/static/js/html2canvas.min.js') }}"></script>
<script src="{{ asset('/static/js/FileSaver.js') }}"></script>
<script src="{{ asset('/static/js/fabric.min.js') }}"></script>
<script>
function convert(whatReturn) {
    html2canvas(document.querySelector("#constructor .canvas-container")).then(canvas => {
        switch(whatReturn) {
            // Скачать ескиз файлом
            case 'file': {
                canvas.toBlob(function(blob) {
                    saveAs(blob, "eskiz.png");
                });
            } break;
            // Прикрепить к заказу в base64
            case 'code': {
                // TODO: Собрать все данные от конструктора
                $("#eskiz_field").val(canvas.toDataURL('image/png'));
            } break;
        }
        $("#send_order").attr('disabled', false);
    });
}
</script>
<script src="{{ asset('/static/js/interact.min.js') }}"></script>
<script src="{{ asset('/static/js/order.js') }}"></script>
@endif
<!-- /Заказ -->

<script src="{{ asset('/static/js/custom.js') }}"></script>
</body>
</html>
