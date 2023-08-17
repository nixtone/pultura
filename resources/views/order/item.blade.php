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
                <form action="{{ route('order.update', $order) }}" method="post" id="status_area">
                    @csrf
                    @method('patch')
                    <select name="status_id" id="status_selected" class="field">
                        @foreach($statusList as $status)
                            <option value="{{ $status->id }}" @if($status->id == $order->status->id) selected @endif class="status c{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <input type="submit" value="Сменить" class="btn">
                </form>
            </td>
            <td class="tac">{{ $order->deadline_date }}</td>
            <td><strong>Имя: </strong><a href="{{ route('client.item', $order->client->id) }}">{{ $order->client->name }}</a><br> <strong>Телефон: </strong> {{ $order->client->phone }}</td>
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

    {{--
    <table class="list">
        <tr>
            <th colspan="3">Внешний вид памятника</th>
            <th>Эскиз</th>

        </tr>
        <tr>
            <td><strong>Модель:</strong></td>
            <td colspan="2"> @if(isset($order->model->category_id)) {{ $categoryList->find($order->model->category_id)->name }} "{{ $order->model->name }}" @endif</td>
            <td rowspan="7" class="tac"><img src="{{ asset($order->eskiz) }}" alt=""></td>
        </tr>
        <tr>
            <td><strong>Размер</strong></td>
            <td colspan="2">{{ $order->model_size }}</td>
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
    --}}

    <h2>Текст для памятника</h2>
    <table class="s1">
        <tr>
            <th width="140px">Фамилия</th>
            <td>{{ $order->lastname }}</td>
            <td rowspan="6" width="460px" class="tac">
                <h3>Эскиз</h3>
                <img src="{{ asset($order->eskiz) }}" alt="">
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
    <table class="list">
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
            <td class="tac">{{-- TODO: Количество --}}</td>
            <td class="tac">
                {{--
                TODO: фиксировать вывод пустых значений
                $order->price_list['lastname'] +
                $order->price_list['firstname'] +
                $order->price_list['fathername'] +
                $order->price_list['birth_date'] +
                $order->price_list['death_date']
                --}}
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
    </table>

    {{--
    <pre>
    @php
    print_r($order->price_list);
    @endphp
    </pre>
    --}}

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
            <td colspan="5" class="tar total_amount"><span class="item amount">Стоимость заказа: <strong class="digit">{{ $order->price_list['total'] }}</strong></span></td>
        </tr>
    </table>

</div>

@endsection
