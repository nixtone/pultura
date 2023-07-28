@extends('design')

@section('title', 'Заказ: '.$order->id)
@section('content')

<div id="order" class="item block">

    <table class="list">
        <tr>
            <th>Статус</th>
            <th>Исполнить до</th>
            <th>Клиент</th>
            <th>Вывод</th>
        </tr>
        <tr>
            <td>
                <form method="post">
                    @csrf
                    @method('patch')
                    <select name="status_id" id="status_selected" class="field">
                        @foreach($statusList as $status)
                            <option value="{{ $status->id }}" @if($status->id == $order->status->id) selected @endif class="status c{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </form>
            </td>
            <td class="tac">{{ $order->deadline_date }}</td>
            <td><strong>Имя: </strong><a href="{{ route('client.item', $order->client->id) }}">{{ $order->client->name }}</a> <strong>Телефон: </strong> {{ $order->client->phone }}</td>
            <td class="tac">
                <a href="{{ route('order.pdfstream', $order->id) }}" class="btn s1">На печать</a>
                <a href="{{ route('order.pdfdownload', $order->id) }}" class="btn s1">Скачать PDF</a>
                <a href="{{ route('order.contract', $order->id) }}" class="btn s1">Договор</a>
            </td>
        </tr>
        <tr>
            <th>Файлы от клиента</th>
            <th>Адрес доставки</th>
            <th colspan="2">Комментарий</th>
        </tr>
        <tr>
            <td>
                @foreach($order->files as $file)
                    <div><a href="{{ asset($file) }}" data-fancybox="gallery">{{ basename($file) }}</a></div>
                @endforeach
            </td>
            <td style="vertical-align: top">{{ $order->delivery_addr }}</td>
            <td colspan="2" style="vertical-align: top">{{ $order->comment }}</td>
        </tr>
    </table>

    <table class="list">
        <tr>
            <th colspan="3">Внешний вид памятника</th>
            <th>Эскиз</th>

        </tr>
        <tr>
            <td><strong>Модель:</strong></td>
            <td colspan="2"> @if(isset($order->model->category_id)) {{ $categoryList->find($order->model->category_id)->name }} "{{ $order->model->name }}" @endif</td>
            <td rowspan="7" class="tac"><img src="{{ asset('/static/images/upload/eskiz_test.jpg') }}" alt=""></td>
        </tr>
        <tr>
            <td><strong>Материал:</strong></td>
            <td colspan="2">@if(isset($order->material->category_id)) {{ $categoryList->find($order->material->category_id)->name }} "{{ $order->material->name }}" @endif</td>
        </tr>
        <tr>
            <td><strong>Портрет:</strong></td>
            <td colspan="2">@if(isset($order->portrait->category_id)) {{ $categoryList->find($order->portrait->category_id)->name }} "{{ $order->portrait->name }}" @endif</td>
        </tr>
        <tr>
            <th colspan="3">Текст для памятника</th>
        </tr>
        <tr>
            <td><strong>Фамилия:</strong> {{ $order->lastname }}</td>
            <td><strong>Имя:</strong> {{ $order->firstname }}</td>
            <td><strong>Отчество:</strong> {{ $order->fathername }}</td>
        </tr>
        <tr>
            <td><strong>Дата рождения:</strong> {{ $order->birth_date }}</td>
            <td colspan="2"><strong>Дата смерти:</strong> {{ $order->death_date }}</td>
        </tr>
        <tr>
            <td><strong>Эпитафия:</strong></td>
            <td colspan="2">{{ $order->epitafia }}</td>
        </tr>
    </table>


    <h2>Смета</h2>
    <table class="list">
        <tr>
            <th width="100%">Наименования</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        <tr>
            <td>Стелла</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Цветник / надгробие</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Ограда</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Вазы</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Облицовка (тротуарная)</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <th>Гравировка</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        <tr>
            <td>Портрет</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>ФИО</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Даты</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Эпитафия</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
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
        {{-- TODO: Продолжить вывод сметы --}}
        <tr>
            <td>Ветвь</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Свечи</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Ангелы</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Птицы</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <th>Услуги</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        <tr>
            <td>Установка</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Демонтаж</td>
            <td class="tac"></td>
            <td class="tac"></td>
            <td class="tac"></td>
        </tr>
        <tr>
            <td>Доставка</td>
            <td class="tac">11</td>
            <td class="tac">11</td>
            <td class="tac">1030</td>
        </tr>
    </table>


    <h2>Платежи</h2>
    <table class="list">
        <tr>
            <th>Внесено</th>
            <th>Комментрий</th>
            <th>Внесено</th>
            @if($order->status->id != 3)<th colspan="2"><a href="{{ route('pay.create', $order->id) }}" class="btn new">Добавить</a></th>@endif
        </tr>
        @if($order->pay->isEmpty())
            <tr>
                <td colspan="5" class="tac">Отсутствуют</td>
            </tr>
        @else
            @foreach($order->pay as $pay)
                <tr>
                    <td class="tac">{{ $pay->amount }}</td>
                    <td>{{ $pay->comment }}</td>
                    <td class="tac">{{ $pay->created_at }}</td>
                    @if($order->status->id != 3)
                        <td class="tac"><a href="{{ route('pay.edit', $pay->id) }}" class="edit ico"></a></td>
                        <td class="tac">
                            <form action="{{ route('pay.delete', $pay->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="submit" value="" class="delete ico">
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach

        @endif
        <tr class="pay_status">
            <td class="tac"><span class="item paid">Итого: <strong class="digit">{{ $order->paid }}</strong></span></td>
            <td colspan="4">
                @if(!$order->remain)
                    <span class="pay_complete">Оплачено</span>
                @elseif($order->remain < 0)
                    <span class="item remain">Переплачено: <strong class="digit">{{ $order->remain }}</strong></span>
                @else
                    <span class="item remain">Осталось: <strong class="digit">{{ $order->remain }}</strong></span>
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="5" class="tar total_amount"><span class="item amount">Стоимость заказа: <strong class="digit">{{ $order->total_amount }}</strong></span></td>
        </tr>
    </table>


    

    {{--
    <pre>
    Модель стеллы
    Размер стеллы
    Материал
    Портрет

    ФИО
    Даты
    Эпитафия

    Полумесяц
    Крест
    Цветы
    Иконы
    Ветвь
    Свечи
    Ангелы
    Птицы

    Цветник / надгробие
    Ограда
    Вазы

    Облицовка: 5м2, тротуарная
    Установка
    Демонтаж
    Доставка: 11км2
    </pre>
    --}}
        {{--
        @if(collect($order->delivery_addr)->isNotEmpty() AND collect($order->delivery_km)->isNotEmpty())
        <h2>Услуги</h2>
        <table class="list">
            <tr>
                <th>Доставка</th>
            </tr>
            <tr>
                <td><strong>Адрес:</strong> {{ $order->delivery_addr }} <strong>Км:</strong> {{ $order->delivery_km }}</td>
            </tr>
        </table>
        @endif
        --}}

    {{--
     <table class="list">
         @if(collect($order->comment)->isNotEmpty())
             <tr>
                 <th>Комментарий</th>
             </tr>
             <tr>
                 <td>{{ $order->comment }}</td>
             </tr>
         @endif
         @if(!is_null($order->deadline_date))
             <tr>
                 <th>Исполнить заказ до: {{ $order->deadline_date }}</th>
             </tr>
         @endif

         @if(!empty($order->files))
         <tr>
             <th>Файлы от клиента</th>
         </tr>
         @foreach($order->files as $file)
         <tr>
             <td colspan="3">
                 <a href="{{ asset('/storage/order/'.$order->id.'/'.$file) }}">{{ basename($file) }}</a>
             </td>
         </tr>
         @endforeach
         @endif

     </table>
  --}}


    {{--
    <div>
        <p>Имя клиента: <a href="/client-item">Стрельбицкая Жанна Олеговна</a></p>
        <p>Монтажные работы (чьи, где): кл. Песчаная Глинка</p>
        <p>Материал изделия: Гранит Цвет: Габбро Происхождение: Карелия</p>
    </div>

    <table class="list">
        <tr>
            <th>Принят</th>
            <th>Исполнить до</th>
            <th>Статус</th>
        </tr>
        <tr>
            <td>03 май 2023 в 13:48</td>
            <td>15 июнь 2023</td>
            <td>Выполняется</td>
        </tr>
    </table>

    <table class="list">
        <tr>
            <th>Наименования</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        <tr>
            <td>Стелла (размеры: 100х50х5) + подставка (размеры: 60х20х15)</td>
            <td>150</td>
            <td>2</td>
            <td>300</td>
        </tr>
        <tr>
            <th>Услуги</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
        </tr>
        <tr>
            <td>Демонтаж</td>
            <td>110</td>
            <td>3</td>
            <td>330</td>
        </tr>
        <tr>
            <td colspan="4">Итого: 630</td>
        </tr>
    </table>

    <h2>Данные для памятника</h2>

    <table class="list">
        <tr>
            <td>Фамилия:</td>
            <td colspan="3">Стрельбицкая</td>
            <td rowspan="5" style="text-align: center;">
                <img src="/static/images/upload/order/1.png" alt="">
            </td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td colspan="3">Елена</td>
        </tr>
        <tr>
            <td>Отчество:</td>
            <td colspan="3">Павловна</td>
        </tr>
        <tr>
            <td>Дата рождения:</td>
            <td>13.10.1948</td>
            <td>Дата смерти:</td>
            <td>28.04.2021</td>
        </tr>
        <tr>
            <td>Эпитафия:</td>
            <td colspan="3">Ты всегда в наших сердцах</td>
        </tr>
    </table>

    <h2>Внесенные платежи</h2>

    <table class="list">
        <tr>
            <th>Сумма</th>
            <th>Комментарий</th>
        </tr>
        <tr>
            <td class="td">45</td>
            <td class="td">Аванс</td>
        </tr>
    </table>
    --}}



</div>

@endsection
