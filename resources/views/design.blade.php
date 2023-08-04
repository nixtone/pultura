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
    src: url('{{ asset('/static/opensans/OpenSans-Extrabold.woff2') }}') format('woff2'),
    url('{{ asset('/static/opensans/OpenSans-Extrabold.woff') }}') format('woff');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Open Sans';
    src: url('{{ asset('/static/opensans/OpenSans-Bold.woff2') }}') format('woff2'),
    url('{{ asset('/static/opensans/OpenSans-Bold.woff') }}') format('woff');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Open Sans';
    src: url('{{ asset('/static/opensans/OpenSans.woff2') }}') format('woff2'),
    url('{{ asset('/static/opensans/OpenSans.woff') }}') format('woff');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}

@if(Route::is('order.create'))
@font-face {
    font-family: "timesbi";
    src:url("/static/fonts/timesbi.ttf") format("truetype");
    font-style: normal;
    font-weight: normal;
}
@font-face {
    font-family: "timesbd";
    src:url("/static/fonts/timesbd.ttf") format("truetype");
    font-style: normal;
    font-weight: normal;
}
@font-face {
    font-family: "arialbd";
    src:url("/static/fonts/arialbd.ttf") format("truetype");
    font-style: normal;
    font-weight: normal;
}
@font-face {
    font-family: "Academy";
    src:url("/static/fonts/academyc.otf") format("truetype");
    font-style: normal;
    font-weight: normal;
}
@font-face {
    font-family: "cyrillicold";
    src: url("/static/fonts/CyrillicOldBold/CyrillicOldBold.eot");
    src: url("/static/fonts/CyrillicOldBold/CyrillicOldBold.eot?#iefix") format("embedded-opentype"),
    url("/static/fonts/CyrillicOldBold/CyrillicOldBold.woff") format("woff"),
    url("/static/fonts/CyrillicOldBold/CyrillicOldBold.ttf") format("truetype");
    font-style: normal;
    font-weight: normal;
}
@font-face {
    font-family: anastasia;
    src: url("/static/fonts/anastasia.ttf");
    font-style: normal;
    font-weight: normal;
}
@font-face {
    font-family: carolina;
    src: url("/static/fonts/carolina.ttf");
    font-style: normal;
    font-weight: normal;
}
@font-face {
    font-family: asessor;
    src: url("/static/fonts/asessor.ttf");
    font-style: normal;
    font-weight: normal;
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
                    <a href="{{ route('home') }}" class="active1">Заказы</a>
                    <a href="{{ route('client.list') }}">Клиенты</a>
                    <a href="{{ route('catalog.category.list') }}">Каталог</a>
                    <a href="{{ route('user.list') }}">Сотрудники</a>
                    <a href="{{ route('help') }}">Справка</a>
                </nav>
            </div>
            <div class="user_area col c2">
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
    <div class="container">CRM <?=date('Y')?></div>
</footer>

<div class="overlay" style="display: none;">
    <div class="popup">
        <div class="close"></div>
        <div class="inner">

            @if(Route::is('order.create'))
                @include('order.inc.window', [
                    'title' => 'Модели памятников',
                    'field' => 'model',
                    'parent_cat' => 1,
                    'displayName' => 0
                ])
                @include('order.inc.window', ['title' => 'Материал', 'field' => 'material', 'parent_cat' => 4, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Портрет', 'field' => 'portrait', 'parent_cat' => 7, 'displayName' => 1])

                @include('order.inc.window', ['title' => 'Полумесяц', 'field' => 'crescent', 'parent_cat' => 27, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Кресты', 'field' => 'cross', 'parent_cat' => 11, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Цветы', 'field' => 'flower', 'parent_cat' => 12, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Иконы', 'field' => 'icon', 'parent_cat' => 26, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Ветви', 'field' => 'branch', 'parent_cat' => 13, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Свечи', 'field' => 'candle', 'parent_cat' => 14, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Ангелы', 'field' => 'angel', 'parent_cat' => 15, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Птицы', 'field' => 'bird', 'parent_cat' => 16, 'displayName' => 1])

                @include('order.inc.window', ['title' => 'Цветник / надгробие', 'field' => 'tombstone', 'parent_cat' => 17, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Ограда', 'field' => 'fence', 'parent_cat' => 18, 'displayName' => 1])
                @include('order.inc.window', ['title' => 'Вазы', 'field' => 'vase', 'parent_cat' => 19, 'displayName' => 1])
            @endif

        </div>
    </div>
</div>

<script src="{{ asset('/static/jquery.min.js') }}"></script>
<script src="{{ asset('/static/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('/static/fancy/jquery.fancybox.min.js') }}"></script>
@if(Route::is('order.create'))
<script src="{{ asset('/static/html2canvas.min.js') }}"></script>
<script src="{{ asset('/static/FileSaver.js') }}"></script>
<script>
function convert() {
    html2canvas(document.querySelector("#constructor .monument.part")).then(canvas => {
        // Сохраняем содержимое холста как файл и скачиваем
        /*
        canvas.toBlob(function(blob) {
            saveAs(blob, "hangge.png");
        });
        */
        //console.log(canvas.toDataURL('image/png'));
        //$("#comment").html(canvas.toDataURL('image/png'));

        $("#eskiz_image").val(canvas.toDataURL('image/png'));
        $("#send_order").attr('disabled', false);
    });
}
</script>
<script src="{{ asset('/static/interact.min.js') }}"></script>
<script src="{{ asset('/static/order.js') }}"></script>
@endif
<script src="{{ asset('/static/custom.js') }}"></script>
</body>
</html>
