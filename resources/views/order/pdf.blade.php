<!doctype html>
<html lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title>Заказ {{ $order->id }}</title>
<style>
     @page {
            margin: 20px 25px !important;
        }
body {
    font-family: "Arial", "Times New Roman";
    font-size: 10px;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin: 15px 0;
}
td, th {
    border: 1px solid;
    padding: 3px;
}

.tac {
    text-align: center;
}
/*
.clear:before, .clear:after {
  clear: both;
  content: "";
  display: block;
}

.justify {
    text-align: justify;
    width: 100%;
}
.justify * {
    display: inline-block;
    float: left;
}
*/
</style>
</head>
<body>

<div id="page">
    <div class="tac">Наряд-заказ № {{ $order->id }} (И.П.Сафиуллин С.Х.)</div>
    <div class="tac">Расчет стоимости материалов и работ.</div>
    <div class="justify">
        <div>Дата приема: {{ date("d.m.Y", strtotime($order->created_at)) }}</div>
        <div>Желаемый срок исполнения до {{ date("d.m.Y", strtotime($order->deadline_date)) }} г.</div>
        <div class="clear"></div>
    </div>
    <div>Заказчик: {{ $order->client->name }}</div>
    @if(!empty($order->client->addr))<div>Адрес_____</div>@endif
    <div>Телефон: {{ $order->client->phone }}</div>
    <div>Монтажные работы(чьи,где)_____</div>
    <div>
        <div>Материал изделия: @if(isset($order->material->category_id)) {{ $categoryList->find($order->material->category_id)->name }} @endif</div>
        <div>Цвет: {{ $order->material->name }}</div>
    </div>
    <table>
        <tr>
            <th>Перечень работ и услуг</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Стоимость</th>
        </tr>
        <tr>
            <td>Стелла (размеры см - ) + подставка(   )</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Цветник</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Фигурная резка: форма(___)</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Фаски (стелла, подставка, только мрамор), окантовка (стелла гранит)</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Гравировка ФИО, даты</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Доп.знаки</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Полумесяц или крест (какой)</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>ИЛИ ПАМЯТНИК ПО ОБРАЗЦУ №___</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td>
                <div>
                    <div>Демонтаж</div>
                    <div>Переноска(м)</div>
                </div>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Погрузка</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Доставка</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Монтаж тумбы и стеллы с переноской до 25м</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Монтаж цветника с переноской до 25м</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Переноска каждые следующие 25м</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Монтаж дополнительно:</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Ограда (размер, цвет, модель)</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Доставка и монтаж ограды (без бетонирования)</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Облицовка (материал, цвет, размеры(м))</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Усиление фундамента облицовки в двухместных оградах</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Итого</td>
            <td>0</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Итого(со скид.)</td>
            <td>0</td>
        </tr>

        <!-- (tr>td*4) -->
    </table>

    <table>
        <tr>
            <th>Кому (ФИО, Даты, Эпитафия)</th>
            <th>Эскиз или образец №</th>
            <th>№ гравировок<br> Прилож №2</th>
        </tr>
        <tr>
            <td>Фамилия: {{ $order->lastname }}</td>
            <td rowspan="5"></td>
            <td></td>
        </tr>
        <tr>
            <td>Имя: {{ $order->firstname }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Отчество: {{ $order->fathername }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Даты: {{ $order->birth_date }} — {{ $order->death_date }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Эпитафия: {{ $order->epitafia }}</td>
            <td></td>
        </tr>

        <!-- tr>td*3 -->
    </table>

    <div>Памятник осмотрен со всех сторон, претензий не имею, с условиями заказа ознакомлен и согласен, данные, надписей верны,<br> адрес и № телефона верны./_______/ Подпись Заказчика</div>
    <div>Аванс, (полную оплату) в сумме _____ 00 коп получил. /___/ Подпись приёмщика, печать.</div>
    <div>Справку на оформление "Разрешения" (см.п.3.2.2 "Договора") получил: /___/ Подпись заказчика.</div>
</div>

</body>
</html>
