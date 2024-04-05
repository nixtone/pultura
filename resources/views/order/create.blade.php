@extends('design')

@section('title', 'Новый заказ')
@section('content')
<div id="order" class="new block">
    <div class="inner">
        <form id="order_create" action="{{ route('order.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="field_group user_choose">
                <h2>Клиент</h2>

                {{--
                @error('status_id') <span class="err">{{ $message }}</span> @enderror
                <input type="hidden" name="status_id" value="1">
                --}}

                {{--
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
                --}}
{{--                <div class="row c2">--}}
                    <div class="field_area">
                        <select name="client_id" class="field">
                            @foreach($clientList as $client)
                            <option value="{{ $client->id }}" @if($clientID == $client->id) selected @endif>{{ $client->name }} / {{ $client->phone }}</option>
                            @endforeach
                        </select>
                    </div>
{{--                </div>--}}
            </div>

            <div class="field_group">
                <h2>Внешний вид памятника</h2>
                <div class="field_area inline">
                    <input type="checkbox" name="model" id="model" class="ppField cpp" data-pp="model" value="0">
                    <label for="model">Модель <span class="product_name"></span></label>
                </div>
                <div class="field_area model-size_area" style="display: none;">
                    <label for="">Размер стеллы</label>
                    @foreach($categoryList->where('parent_id', 1) as $modelCat)
                        <select name="model_size" class="field model-size c{{ $modelCat->id }} priceRequestChange" data-cat="{{ $modelCat->id }}" style="display: none;">
                            @foreach($sizeList as $size)
                                @if($size->category_id == $modelCat->id)
                                <option value="{{ $size->id }}" data-w="{{ $size->width }}" data-h="{{ $size->height }}">{{ $size->width }} x {{ $size->height }} x {{ $size->thick }}</option>
                                @endif
                            @endforeach
                        </select>
                    @endforeach
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="material" id="material" class="ppField priceRequestClick cpp" data-pp="material" value="0">
                    <label for="material">Материал <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="portrait" id="portrait" class="ppField priceRequestClick cpp" data-pp="portrait" value="0">
                    <label for="portrait">Портрет <span class="product_name"></span></label>
                </div>
            </div>

            <div class="field_group">
                <h2>Текст для памятника</h2>
                <!-- <div class="advice">Что бы не кликать каждый раз на следующее поле, можно нажимать "tab"</div> -->
                <div class="field_area">
                    <label for="lastname">Фамилия</label>
                    <div class="wrap">
                        <input type="text" name="lastname" id="lastname" class="field text priceRequestKeyup" data-font="main">
                        <input type="number" name="" class="field size" value="20">
                    </div>
                </div>
                <div class="field_area">
                    <label for="firstname">Имя</label>
                    <div class="wrap">
                        <input type="text" name="firstname" id="firstname" class="field text priceRequestKeyup" data-font="main">
                        <input type="number" name="" class="field size" value="14">
                    </div>
                </div>
                <div class="field_area">
                    <label for="fathername">Отчество</label>
                    <div class="wrap">
                        <input type="text" name="fathername" id="fathername" class="field text priceRequestKeyup" data-font="main">
                        <input type="number" name="" class="field size" value="14">
                    </div>
                </div>
                <div class="field_area">
                    <table>
                        <tr>
                            <td><label for="birth_date">Дата рождения</label></td>
                            <td></td>
                            <td><label for="death_date">Дата смерти</label></td>
                        </tr>
                        <tr>
                            <td class="wrap">
                                <input type="text" name="birth_date" id="birth_date" class="field text priceRequestKeyup" data-font="main">
                                <input type="number" name="" class="field size" value="14">
                            </td>
                            <td>
                                {{--
                                <div class="field_area inline">
                                    <input type="checkbox" name="" id="defis">
                                    <label for="defis"></label>
                                </div>
                                --}}
                            </td>
                            <td class="wrap">
                                <input type="text" name="death_date" id="death_date" class="field text priceRequestKeyup" data-font="main">
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
                        <textarea name="epitafia" id="epitafia" cols="3" class="field text priceRequestKeyup" data-font="epitafia"></textarea>
                        <input type="number" name="" class="field size" value="18">
                    </div>
                </div>

                @include('order.inc.font', ['title' => 'Шрифт эпитафии', 'group' => 'epitafia'])

            </div>

            <div class="field_group">
                <h2>Гравировка</h2>
                <div class="field_area inline">
                    <input type="checkbox" name="crescent" id="crescent" class="ppField cpp" data-pp="crescent" value="0">
                    <label for="crescent">Полумесяц <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="cross" id="cross" class="ppField cpp" data-pp="cross" value="0">
                    <label for="cross">Крест <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="flower" id="flower" class="ppField cpp" data-pp="flower" value="0">
                    <label for="flower">Цветы <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="icon" id="icon" class="ppField cpp" data-pp="icon" value="0">
                    <label for="icon">Иконы <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="branch" id="branch" class="ppField cpp" data-pp="branch" value="0">
                    <label for="branch">Ветвь <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="candle" id="candle" class="ppField cpp" data-pp="candle" value="0">
                    <label for="candle">Свечи <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="angel" id="angel" class="ppField cpp" data-pp="angel" value="0">
                    <label for="angel">Ангелы <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="bird" id="bird" class="ppField cpp" data-pp="bird" value="0">
                    <label for="bird">Птицы <span class="product_name"></span></label>
                </div>
            </div>

            <div class="field_group">
                <h2>Дополнения</h2>
                <div class="field_area inline">
                    <input type="checkbox" name="tombstone" id="tombstone" class="ppField cpp" data-pp="tombstone">
                    <label for="tombstone">Цветник / надгробие <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="fence" id="fence" class="ppField cpp" data-pp="fence">
                    <label for="fence">Ограда <span class="product_name"></span></label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="vase" id="vase" class="ppField cpp" data-pp="vase">
                    <label for="vasee">Вазы <span class="product_name"></span></label>
                </div>
            </div>

            <div class="field_group">
                <h2>Облицовка</h2>
                <div class="field_area">
                    <label for="face_m2">Площадь (м<sup>2</sup>)</label>
                    <input type="text" name="face_m2" id="face_m2" class="field priceRequestKeyup">
                </div>
                <div class="field_area">
                    <select name="facing" id="" class="field priceRequestChange">
                        <option value="0" selected></option>
                        @foreach($productList->where('category_id', 23) as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} / {{ $product->price }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{----}}
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
                            <td><input type="text" name="delivery_km" id="delivery_km" class="field text priceRequestKeyup"></td>
                        </tr>
                    </table>
                </div>
                <div class="field_area">
{{--                    <input type="checkbox" name="install" id="install">--}}

                    <label for="install">Установка (стоимость)</label>
                    <input type="text" name="install" id="install" class="field priceRequestKeyup">
                </div>
                <div class="field_area">
{{--                    <input type="checkbox" name="deinstall" id="deinstall">--}}
                    <label for="deinstall">Демонтаж (стоимость)</label>
                    <input type="text" name="deinstall" id="deinstall" class="field priceRequestKeyup">
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

            <div class="field_group">
                <h2>Остальное</h2>
                <div class="field_area">
                    <label for="deadline_date">Исполнить заказ до:</label>
                    <input type="text" name="deadline_date" id="deadline_date" class="field text datemask">
                </div>
                <div class="field_area">
                    <label for="files">Файлы от клиента (фото усопшего, документы...)</label>
                    <input type="file" name="files[]" id="files" class="field" multiple>
                </div>
                <div class="field_area">
                    <label for="total_amount">Корректировка цены</label>
                    <input type="text" value="0" id="total_amount" class="field priceRequestKeyup">
                </div>
                <div class="field_area">
                    <label for="comment">Комментарий к заказу</label>
                    <textarea name="comment" id="comment" rows="5" class="field"></textarea>
                </div>
            </div>

            {{-- --}}

            <div class="field_area">
                <input type="hidden" id="price_list" name="price_list">
                <input type="hidden" id="eskiz_image" name="eskiz_image">
                <button type = "button" name = "button" onclick = "convert()" class="btn s1">Сохранить эскиз</button>
                <input type="submit" id="send_order" value="Создать заказ" class="btn s1" disabled>
            </div>
        </form>
        <div id="constructor">
            <h2>Эскиз памятника</h2>
            <div class="sticky">
                <div class="preload" style="display: none">
                    <img src="{{ asset('/static/images/preload.gif') }}" alt="" class="pic">
                </div>
                <div class="monument part" style="width: 160px; height: 320px;">
                    <div class="negative">

                        <div class="item portrait">
                            <img src="" alt="" class="preview bimg">
                        </div>

                        <div class="item lastname font_main"></div>
                        <div class="item firstname font_main"></div>
                        <div class="item fathername font_main"></div>
                        <div class="item birth_date font_main"></div>
                        <div class="item death_date font_main"></div>
                        <pre class="item epitafia font_epitafia"></pre>

                        <div class="item cross">
                            <img src="" alt="" class="preview bimg" style="max-width: 50px;">
                        </div>
                        <div class="item flower">
                            <img src="" alt="" class="preview bimg" style="max-width: 130px;">
                        </div>
                        <div class="item branch">
                            <img src="" alt="" class="preview bimg" style="max-width: 130px;">
                        </div>
                        <div class="item candle">
                            <img src="" alt="" class="preview bimg" style="max-width: 50px;">
                        </div>
                        <div class="item angel">
                            <img src="" alt="" class="preview bimg" style="max-width: 130px;">
                        </div>
                        <div class="item bird">
                            <img src="" alt="" class="preview bimg" style="max-width: 130px;">
                        </div>
                    </div>
                </div>
                <div class="postament part" style="width: 180px; height: 60px;"></div>
                <div id="order-total">Итого: <span class="digit">0</span> ₽</div>
            </div>
        </div>

    </div><!-- .inner -->
</div><!-- #order -->



@endsection
