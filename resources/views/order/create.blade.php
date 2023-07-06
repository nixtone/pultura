@extends('design')

@section('title', 'Новый заказ')
@section('content')
<div id="order" class="new block">
    <div class="inner">
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="field_group user_choose">
                <h2>Клиент</h2>

{{--
                @error('status_id') <span class="err">{{ $message }}</span> @enderror
                <input type="hidden" name="status_id" value="1">
--}}
                <div class="field_area inline">
                    <input type="radio" name="choose_client" id="choose_client1" value="1" checked>
                    <label for="choose_client1">Новый</label>
                </div>
                <div class="row c1 active">
                    <div class="field_area">
                        <label for="client_name">Имя @error('name') <span class="err">{{ $message }}</span>@enderror</label>
                        <input type="text" name="name" id="client_name" class="field" value="{{ old('name') }}">
                    </div>
                    <div class="field_area">
                        <label for="client_phone">Телефон @error('phone') <span class="err">{{ $message }}</span>@enderror</label>
                        <input type="text" name="phone" id="client_phone" class="field phonemask" value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="field_area inline">
                    <input type="radio" name="choose_client" id="choose_client2" value="2">
                    <label for="choose_client2">Зарегестированный</label>
                </div>
                <div class="row c2">
                    <div class="field_area">
                        <select name="client_id" class="field">
                            <option value="0"></option>
                            @foreach($clientList as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} / {{ $client->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="field_group">
                <h2>Внешний вид памятника</h2>
                <div class="field_area inline cpp" data-pp="model">
                    <input type="checkbox" name="model" id="model" class="ppField">
                    <label for="model">Модель <span class="product_name"></span></label>
                </div>
                <div class="field_area inline cpp" data-pp="material">
                    <input type="checkbox" name="material" id="material" class="ppField">
                    <label for="material">Материал <span class="product_name"></span></label>
                </div>
                <div class="field_area inline cpp" data-pp="portrait">
                    <input type="checkbox" name="portrait" id="portrait" class="ppField">
                    <label for="portrait">Портрет <span class="product_name"></span></label>
                </div>
                <div class="field_area">
                    <label for="">Размер стеллы</label>
                    <select name="" id="" class="field">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="field_group">
                <h2>Текст для памятника</h2>
                <!-- <div class="advice">Что бы не кликать каждый раз на следующее поле, можно нажимать "tab"</div> -->
                <div class="field_area">
                    <label for="lastname">Фамилия</label>
                    <div class="wrap">
                        <input type="text" name="lastname" id="lastname" class="field text" data-font="main">
                        <input type="number" name="" class="field size" value="20">
                    </div>
                </div>
                <div class="field_area">
                    <label for="firstname">Имя</label>
                    <div class="wrap">
                        <input type="text" name="firstname" id="firstname" class="field text" data-font="main">
                        <input type="number" name="" class="field size" value="14">
                    </div>
                </div>
                <div class="field_area">
                    <label for="fathername">Отчество</label>
                    <div class="wrap">
                        <input type="text" name="fathername" id="fathername" class="field text" data-font="main">
                        <input type="number" name="" class="field size" value="14">
                    </div>
                </div>
                <div class="field_area">
                    <table>
                        <tr>
                            <td><label for="birth_date">Дата рождения</label></td>
                            <td><label for="death_date">Дата смерти</label></td>
                        </tr>
                        <tr>
                            <td class="wrap">
                                <input type="text" name="birth_date" id="birth_date" class="field text datemask" data-font="main">
                                <input type="number" name="" class="field size" value="14">
                            </td>
                            <td class="wrap">
                                <input type="text" name="death_date" id="death_date" class="field text datemask" data-font="main">
                                <input type="number" name="" class="field size" value="14">
                            </td>
                        </tr>
                    </table>
                </div>

                @include('order.inc.font', ['title' => 'Основной шрифт', 'group' => 'main'])

                <!-- <div class="advice">Если фокус стоит на выпадающем списке, можно выбирать его пукты стрелками ↑↓</div> -->
                <div class="field_area">
                    <label for="epitafia">Эпитафия</label>
                    <div class="wrap">
                        <textarea name="epitafia" id="epitafia" cols="3" class="field text"></textarea>
                        <input type="number" name="" class="field size" value="18">
                    </div>
                </div>

                @include('order.inc.font', ['title' => 'Шрифт эпитафии', 'group' => 'epitafia'])

            </div>

            <div class="field_group">
                <h2>Гравировка</h2>
                <div class="field_area inline">
                    <input type="checkbox" name="cross" id="cross">
                    <label for="cross" class="cpp" data-pp="cross">Крест (3)</label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="flower" id="flower">
                    <label for="flower">Цветы</label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="branch" id="branch">
                    <label for="branch">Ветвь (2)</label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="candle" id="candle">
                    <label for="candle">Свечи</label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="angel" id="angel">
                    <label for="angel">Ангелы</label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="bird" id="bird">
                    <label for="bird">Птицы</label>
                </div>
            </div>

            <div class="field_group">
                <h2>Дополнения</h2>
                <div class="field_area inline">
                    <input type="checkbox" name="tombstone" id="tombstone">
                    <label for="tombstone">Цветник / надгробие</label>
                </div>
            </div>

            <div class="field_group">
                <h2>Услуги</h2>
                <div class="field_area">
                    <table>
                        <tr>
                            <td><label for="delivery_addr">Адрес доставки</label></td>
                            <td><label for="delivery_km">Км</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="delivery_addr" id="delivery_addr" class="field"></td>
                            <td><input type="text" name="delivery_km" id="delivery_km" class="field"></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="field_group">
                <h2>Платеж</h2>
                <div class="field_area">
                    <table>
                        <tr>
                            <td><label for="pay_amount">Сумма</label></td>
                            <td><label for="pay_comment">Комментарий</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="pay_amount" id="pay_amount" class="field"></td>
                            <td><input type="text" name="pay_comment" id="pay_comment" class="field"></td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- --}}

            <div class="field_area">
                <input type="submit" value="Создать заказ" class="btn">
            </div>
        </form>

        <div id="constructor">
            <h2>Эскиз памятника</h2>
            <div class="sticky">
                <div class="preview">
                    <div class="item portrait">
                        <img src="/static/images/upload/port.png" alt="">
                    </div>
                    <div class="item lastname font_main"></div>
                    <div class="item firstname font_main"></div>
                    <div class="item fathername font_main"></div>
                    <div class="item birth_date font_main"></div>
                    <div class="item death_date font_main"></div>
                    <div class="item epitafia font_epitafia"></div>
                </div>
                <div id="order-total">Итого: <span class="digit">107305</span> ₽</div>
            </div>
        </div>

    </div><!-- .inner -->
</div><!-- #order -->



@endsection
