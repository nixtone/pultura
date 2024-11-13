@extends('design')

@section('title', 'Заказ: '.$order->id)
@section('content')

<div id="order" class="item block" data-id="{{ $order->id }}">

    <div class="btn_area">
        <a href="{{ route('order.pdfdownload', $order->id) }}" class="btn">Скачать PDF</a>
        <a href="{{ route('order.pdfstream', $order->id) }}" class="btn">Просмотр</a>
        <a href="{{ route('order.contract', $order->id) }}" class="btn">Договор</a>
    </div>

    <table class="list">
        <tr>
            <th>Статус</th>
            <th>Создан</th>
            <th>Исполнить до</th>
            <th>Осталось дней</th>
            <th>Клиент</th>
        </tr>
        <tr>
            <td>
                <form action="{{ route('order.update', $order) }}" method="post">
                    @csrf
                    @method('patch')
                    <select name="status_id" id="status_id" class="field">
                        @foreach($statusList as $status)
                        <option value="{{ $status->id }}" @if($status->id == $order->status_id) selected @endif>{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="client_id" value="{{ $order->client_id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="id" value="{{ $order->id }}">
                </form>
            </td>
            <td class="tac">{{ $order->created_at_ru }}</td>
            <td class="tac">{{ $order->deadline_date_ru }}</td>
            <td class="tac">{{ $order->dayRest }}</td>
            <td class="tac"><a href="{{ route('client.item', $order->client->id) }}">{{ $order->client->name }}</a></td>
        </tr>
        @if(!empty($order->comment))
        <tr>
            <th colspan="5">Комментарий:</th>
        </tr>
        <tr>
            <td colspan="5">
                <div>{{ $order->comment }}</div>
            </td>
        </tr>
        @endif
        <tr>
            <th colspan="1">Эскиз:</th>
            <th colspan="4">Файлы от клиента:</th>
        </tr>
        <tr>
            <td colspan="1">
                <a href="{{ $order->eskiz }}" data-fancybox="gallery" class="eskiz_link">
                    <img src="{{ $order->eskiz }}" alt="" class="bimg eskiz">
                </a>
            </td>
            <td colspan="4" class="client-file_area">
                @foreach($order->ClientFile as $fileName => $filePath)
                    <div><a href="{{ asset($filePath) }}" target="_blank">{{ $fileName }}</a></div>
                @endforeach
            </td>
        </tr>
        {{--
        <tr>
            <th colspan="5">Экиз:</th>
        </tr>
        <tr>
            <td colspan="5">

            </td>
        </tr>
        <tr>
            <th colspan="5">Файлы от клиента:</th>
        </tr>
        <tr>
            <td colspan="5">

            </td>
        </tr>
        --}}
    </table>

    <table id="smeta" class="list">
        <tr>
            <td class="h2" colspan="4">Смета</td>
        </tr>
        <tr>
            <th>Наименование</th>
            <th>Количество</th>
            <th>Сумма</th>
            <th>Итого</th>
        </tr>
        @foreach($order->estimateRU as $label => $arEstItem)
        <tr class="descr">
            <td colspan="4">{{ $label }}</td>
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
            <td class="tac" style="font-size: 1.5em; font-weight: bold; color: @if($estimateTotal['rest']) red @else green @endif">{{ $order->total_correct }}</td>
        </tr>
        <tr>
            <td class="tar" colspan="3">Разница итога и корректировки:</td>
            <td class="tac">{{ $estimateTotal['diff_total'] }}</td>
        </tr>
        @endif
        <tr>
            <td class="tar" colspan="3">Осталось:</td>
            <td class="tac">{{ $estimateTotal['rest'] }}</td>
        </tr>
    </table>


    <table id="pay_list" class="list">
        <tr>
            <td colspan="3" class="h2">Платежи<a href="#" class="btn in-title invert cpp" data-pp="pay_add">Внести</a></td>
        </tr>
        @if($estimateTotal['paymentList'])
            <tr>
                <th>Комментарий</th>
                <th>Когда поступил</th>
                <th>Сумма</th>
            </tr>
            @foreach($estimateTotal['paymentList'] as $payItem)
                <tr class="pay">
                    <td>{{ $payItem['comment'] }}</td>
                    <td class="tac">{{ $payItem->created_at_ru }}</td>
                    <td class="tac">{{ $payItem['amount'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="tar" colspan="2">Всего внесено:</td>
                <td class="tac"><strong>{{ $estimateTotal['payTotal'] }}</strong></td>
            </tr>
        @else

        @endif
    </table>

</div>
@endsection
