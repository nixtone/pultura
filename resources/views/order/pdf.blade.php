<!doctype html>
<html lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title>Заказ {{ $order->id }}</title>
<style>
/* Структура */
@page {
    margin: 20px 25px !important;
}
body {
    font-family: "Arial", "Times New Roman";
    font-size: 10px;
}

/* Атомарные */
.tac {
    text-align: center;
}
.tar {
    text-align: right;
}
.italic {
    font-style: italic;
}
table.list {
    border-collapse: collapse;
    margin: 15px 0;
    width: 100%;

}
table.list td, table.list th {
    padding: 4px;
    box-sizing: border-box;
    border: 1px solid #dddbdb;
}

/* Reset */
h1, h2, h3 {
    margin: 0 0 15px;
}
p {
    line-height: 18px;
}
ul, ol, li {
    margin: 0;
    padding: 0;
}
ol {
    /* убираем стандартную нумерацию */
    list-style: none;
    /* Идентифицируем счетчик и даем ему имя li. Значение счетчика не указано - по умолчанию оно равно 0 */
    counter-reset: li;
}
li:before {
    /* Определяем элемент, который будет нумероваться — li. Псевдоэлемент before указывает, что содержимое,
     вставляемое при помощи свойства content, будет располагаться перед пунктами списка. Здесь же устанавливается
     значение приращения счетчика (по умолчанию равно 1). */
    counter-increment: li;
    /* С помощью свойства content выводится номер пункта списка. counters() означает, что генерируемый текст
     представляет собой значения всех счетчиков с таким именем. Точка в кавычках добавляет разделяющую точку
     между цифрами, а точка с пробелом добавляется перед содержимым каждого пункта списка */
    content: counters(li, ".") ". ";
}

</style>
</head>
<body>

<div id="page">
    <div class="tac">Наряд-заказ № <strong>{{ $order->id }}</strong> (И.П.Сафиуллин С.Х.)</div>
    <div class="tac">Расчет стоимости материалов и работ.</div>

    <table style="margin: 15px 0">
        <tr>
            <td width="50%">Дата приема: {{ date("d.m.Y", strtotime($order->created_at)) }}</td>
            <td style="text-align: right;">Желаемый срок исполнения до {{ date("d.m.Y", strtotime($order->deadline_date)) }} г.</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Заказчик:</strong> {{ $order->client->name }} / <strong>Телефон:</strong> {{ $order->client->phone }}</td>
        </tr>
        @if(!empty($order->client->addr))
            <tr>
                <td>Адрес: {{ $order->client->addr }}</td>
            </tr>
        @endif
        <tr>
            <td colspan="2">Монтажные работы(чьи,где): ___________________________________________________________________________________________________________________</td>
        </tr>
        {{--
        <tr>
            <td>Материал изделия: @if(isset($order->material)) {{ $categoryList->find($order->material->category_id)->name }} @else _______________________ @endif</td>
            <td>Цвет: @if(isset($order->material)) {{ $order->material->name }} @else _______________________ @endif</td>
        </tr>
        --}}
    </table>

    <h2 class="tac">Смета</h2>

    <table id="smeta" class="list">
        <tr>
            <th>Наименование</th>
            <th>Количество</th>
            <th>Сумма</th>
            <th>Итого</th>
        </tr>
        @foreach($order->estimateRU as $label => $arEstItem)
            <tr class="descr">
                <td colspan="4" class="italic tac">{{ $label }}</td>
            </tr>
            @foreach($arEstItem as $estItem)
                <tr>
                    <td>{!! $estItem['label'] !!} @if($label == "Тексты") {{ $estItem['valueString'] }} @endif</td>
                    <td class="tac">{{ $estItem['count'] }}</td>
                    <td class="tac">{{ $estItem['subtotal'] }}</td>
                    <td class="tac">{{ $estItem['total'] }}</td>
                </tr>
            @endforeach
        @endforeach

        <tr>
            <td class="tar" colspan="3">Итого:</td>
            @if($order->total_correct)
                <td class="tac noactive" style="font-size: 1.5em; font-weight: bold;">
            @else
                <td class="tac" style="font-size: 1.5em; font-weight: bold; color: @if($estimateTotal['rest']) red @else green @endif">
            @endif
                {{ $order->price }}
                </td>
        </tr>

        @if($order->total_correct)
            <tr>
                <td class="tar" colspan="3">Корректировка:</td>
                <td class="tac" style="font-size: 1.5em; font-weight: bold;">{{ $order->total_correct }}</td>
            </tr>
            {{--
            <tr>
                <td class="tar" colspan="3">Разница итога и корректировки:</td>
                <td class="tac">{{ $estimateTotal['diff_total'] }}</td>
            </tr>
            --}}
        @endif
        {{--

        --}}
        <tr>
            <td class="tar" colspan="3">Осталось:</td>
            <td class="tac">{{ $estimateTotal['rest'] }}</td>
        </tr>
    </table>

    <div class="sign_area">
        <p>Памятник осмотрен со всех сторон, претензий не имею, с условиями заказа ознакомлен и согласен, данные, надписей верны,<br>
            адрес и номер телефона верны. __________________ Подпись Заказчика</p>
        <p>Аванс, (полную оплату) в сумме _________________________________________________________________________________________________________________<br>
            ______________________________________________________________________________________ 00 коп получил. _________ Подпись приёмщика, печать.</p>
        <p>Справку на оформление "Разрешения" (см.п.3.2.2 "Договора") получил: __________________ Подпись заказчика.</p>
    </div>

{{--


    <table class="s1">
        <tr>
            <th width="140px">Фамилия</th>
            <td>{{ $order->lastname }}</td>
            <td rowspan="6" width="460px" class="tac">

                <img src="{{ $order->EskizBase64 }}" alt="" style="max-height: 200px">
            </td>
        </tr>
        <tr>
            <th>Имя</th>
            <td>{{ $order->firstname }}</td>
        </tr>
        <tr>
            <th>Отчество</th>
            <td>{{ $order->fathername }}</td>
        </tr>
        <tr>
            <th>Дата рождения</th>
            <td>{{ $order->birth_date }}</td>
        </tr>
        <tr>
            <th>Дата смерти</th>
            <td>{{ $order->death_date }}</td>
        </tr>
        <tr>
            <th>Эпитафия</th>
            <td>{{ $order->epitafia }}</td>
        </tr>
    </table>

    <h2>Смета</h2>
    <table class="s1">
        <tr>
            <th width="100%">Наименования</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        @if(!empty($order->model->name))
            <tr>
                <td>Стелла (модель:
                    {{ $categoryList->find($order->model->category_id)->name }}
                    "{{ $order->model->name }}",
                    размер: {{ $order->model_size }},
                    материал: @if(isset($order->material->category_id)) {{ $categoryList->find($order->material->category_id)->name }} "{{ $order->material->name }}" @endif)
                </td>
                <td class="tac">{{ $order->price_list['stella'] }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $order->price_list['stella'] }}</td>
            </tr>
        @endif
        @if(!empty($order->price_list['tombstone']))
            <tr>
                <td>Цветник / надгробие (модель: "{{ $productList->find($order->tombstone)->name }}")</td>
                <td class="tac">{{ $order->price_list['tombstone'] }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $order->price_list['tombstone'] }}</td>
            </tr>
        @endif
        @if(!empty($order->price_list['fence']))
            <tr>
                <td>Ограда (модель: "{{ $productList->find($order->fence)->name }}")</td>
                <td class="tac">{{ $order->price_list['fence'] }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $order->price_list['fence'] }}</td>
            </tr>
        @endif
        @if(!empty($order->price_list['vase']))
            <tr>
                <td>Ваза (модель: "{{ $productList->find($order->vase)->name }}")</td>
                <td class="tac">{{ $order->price_list['vase'] }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $order->price_list['vase'] }}</td>
            </tr>
        @endif
        @if(!empty($order->price_list['facing']))
            <tr>
                <td>Облицовка ({{ $productList->find($order->facing)->name }})</td>
                <td class="tac">{{ $order->price_list['facing'] / $order->face_m2 }}</td>
                <td class="tac">{{ $order->face_m2 }} м<sup>2</sup></td>
                <td class="tac">{{ $order->price_list['facing'] }}</td>
            </tr>
        @endif
        <tr>
            <th>Гравировка</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        @if(!empty($order->portrait))
            <tr>
                <td>Портрет ({{ $categoryList->find($order->portrait->category_id)->name }} "{{ $order->portrait->name }}")</td>
                <td class="tac">{{ $order->price_list['portrait'] }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $order->price_list['portrait'] }}</td>
            </tr>
        @endif
        @if(
            !empty($order->price_list['lastname']) OR
            !empty($order->price_list['firstname']) OR
            !empty($order->price_list['fathername']) OR
            !empty($order->price_list['birth_date']) OR
            !empty($order->price_list['death_date'])
        )
            <tr>
                <td>ФИО и ДАТЫ</td>
                <td class="tac">{{ $order->price_list['lastname'] }}</td>
                <td class="tac">Количество</td>
                <td class="tac">

                    TODO: фиксировать вывод пустых значений
                    $order->price_list['lastname'] +
                    $order->price_list['firstname'] +
                    $order->price_list['fathername'] +
                    $order->price_list['birth_date'] +
                    $order->price_list['death_date']

                </td>
            </tr>
        @endif
        @if(!empty($order->price_list['epitafia']))
            <tr>
                <td>Эпитафия</td>
                <td class="tac">{{ $productList->where('id', 276)->first()->price }}</td>
                <td class="tac">{{ mb_strlen(str_replace(" ", "", $order['epitafia'])) }}</td>
                <td class="tac">{{ mb_strlen(str_replace(" ", "", $order['epitafia'])) * $productList->where('id', 276)->first()->price }}</td>
            </tr>
        @endif
        @if($order->crescent)
            <tr>
                <td>Полумесяц, "{{ $productList->where('id', $order->crescent)->first()->name }}"</td>
                <td class="tac"></td>
                <td class="tac">1</td>
                <td class="tac">{{ $productList->where('id', $order->crescent)->first()->price * 1 }}</td>
            </tr>
        @endif
        @if($order->cross)
            <tr>
                <td>Крест, "{{ $productList->where('id', $order->cross)->first()->name }}"</td>
                <td class="tac">{{ $productList->where('id', $order->cross)->first()->price }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $productList->where('id', $order->cross)->first()->price * 1 }}</td>
            </tr>
        @endif
        @if($order->flower)
            <tr>
                <td>Цветы, "{{ $productList->where('id', $order->flower)->first()->name }}"</td>
                <td class="tac">{{ $productList->where('id', $order->flower)->first()->price }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $productList->where('id', $order->flower)->first()->price * 1 }}</td>
            </tr>
        @endif
        @if($order->icon)
            <tr>
                <td>Иконы, "{{ $productList->where('id', $order->icon)->first()->name }}"</td>
                <td class="tac">{{ $productList->where('id', $order->icon)->first()->price }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $productList->where('id', $order->icon)->first()->price * 1 }}</td>
            </tr>
        @endif
        @if($order->branch)
            <tr>
                <td>Ветвь, "{{ $productList->where('id', $order->branch)->first()->name }}"</td>
                <td class="tac">{{ $productList->where('id', $order->branch)->first()->price }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $productList->where('id', $order->branch)->first()->price * 1 }}</td>
            </tr>
        @endif
        @if($order->candle)
            <tr>
                <td>Свечи, "{{ $productList->where('id', $order->candle)->first()->name }}"</td>
                <td class="tac">{{ $productList->where('id', $order->candle)->first()->price }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $productList->where('id', $order->candle)->first()->price * 1 }}</td>
            </tr>
        @endif
        @if($order->angel)
            <tr>
                <td>Ангелы, "{{ $productList->where('id', $order->angel)->first()->name }}"</td>
                <td class="tac">{{ $productList->where('id', $order->angel)->first()->price }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $productList->where('id', $order->angel)->first()->price * 1 }}</td>
            </tr>
        @endif
        @if($order->bird)
            <tr>
                <td>Птицы, "{{ $productList->where('id', $order->bird)->first()->name }}"</td>
                <td class="tac">{{ $productList->where('id', $order->bird)->first()->price }}</td>
                <td class="tac">1</td>
                <td class="tac">{{ $productList->where('id', $order->bird)->first()->price * 1 }}</td>
            </tr>
        @endif

        <tr>
            <th>Услуги</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        @if($order->install)
            <tr>
                <td>Установка</td>
                <td class="tac"></td>
                <td class="tac">1</td>
                <td class="tac">{{ $order->install * 1 }}</td>
            </tr>
        @endif
        @if($order->deinstall)
            <tr>
                <td>Демонтаж</td>
                <td class="tac"></td>
                <td class="tac">1</td>
                <td class="tac">{{ $order->deinstall * 1 }}</td>
            </tr>
        @endif
        @if($order->delivery_km)
            <tr>
                <td>Доставка</td>
                <td class="tac"></td>
                <td class="tac">{{ $order->delivery_km }} км</td>
                <td class="tac">{{ $order->price_list['delivery_km'] }}</td>
            </tr>
        @endif
        <tr>
            <td colspan="4" class="tar"><strong>Итого:</strong> </td>
        </tr>
    </table>




    {{--
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
    </table>


    --}}
</div>

</body>
</html>
