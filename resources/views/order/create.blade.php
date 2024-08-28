@extends('design')

@section('title', 'Новый заказ')
@section('content')
<div id="order">

        {{-- --}}
        <div class="tab-area order" data-name="order">
            <div class="tab label">
                <div class="tab-item c1" data-count="1">Оформление</div>
                <div class="tab-item c2" data-count="2">Конструктор</div>
            </div>
            <div class="tab page">
                <div class="tab-item c1">

                    <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <!--
                        client_id
                        user_id
                        status_id
                        comment

                        mm_model
                        mm_model_size
                        mm_material
                        mm_details

                        services
                        deadline_date
                        -->

                        {{--
                        <div class="field_area">
                            <div class="err">@error('client_id') {{ $message }} @enderror</div>
                            <input type="text" name="client_id" class="field" placeholder="client_id" value="2">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('user_id') {{ $message }} @enderror</div>
                            <input type="text" name="user_id" class="field" placeholder="user_id" value="1">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('status_id') {{ $message }} @enderror</div>
                            <input type="text" name="status_id" class="field" placeholder="status_id" value="1">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('comment') {{ $message }} @enderror</div>
                            <input type="text" name="comment" class="field" placeholder="comment" value="">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('mm_model') {{ $message }} @enderror</div>
                            <input type="text" name="mm_model" class="field" placeholder="mm_model" value="">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('mm_model_size') {{ $message }} @enderror</div>
                            <input type="text" name="mm_model_size" class="field" placeholder="mm_model_size" value="">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('mm_material') {{ $message }} @enderror</div>
                            <input type="text" name="mm_material" class="field" placeholder="mm_material" value="">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('mm_details') {{ $message }} @enderror</div>
                            <input type="text" name="mm_details" class="field" placeholder="mm_details" value="">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('services') {{ $message }} @enderror</div>
                            <input type="text" name="services" class="field" placeholder="services" value="">
                        </div>
                        <div class="field_area">
                            <div class="err">@error('deadline_date') {{ $message }} @enderror</div>
                            <input type="text" name="deadline_date" class="field" placeholder="deadline_date" value="">
                        </div>
                        <input type="submit" value="Создать">
                        --}}

                        <div class="field_group">
                            <h2>Клиент</h2>
                            <div class="inner">
                                <div class="err">@error('client_id') {{ $message }} @enderror</div>
                                <select name="client_id" id="client_id" class="field">
                                    @foreach($clientList as $client)
                                        <option value="{{ $client->id }}" @if($clientID == $client->id) selected @endif>{{ $client->name }} / {{ $client->phone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="field_group">
                            <h2>Услуги</h2>
                            <div class="inner">
                                <div class="err">@error('services') {{ $message }} @enderror</div>
                                <div class="field_area">
                                    <label for="services_delivery_addr">Адрес доставки</label>
                                    <textarea name="services[delivery][addr]" id="services_delivery_addr" rows="2" class="field"></textarea>
                                </div>
                                <div class="field_area">
                                    <label for="services_delivery_km">Расстояние (км)</label>
                                    <input type="text" name="services[delivery][km]" id="services_delivery_km" class="field">
                                </div>
                                <div class="field_area">
                                    <label for="services_install">Установка (стоимость)</label>
                                    <input type="text" name="services[install]" id="services_install" class="field">
                                </div>
                                <div class="field_area">
                                    <label for="services_deinstall">Демонтаж (стоимость)</label>
                                    <input type="text" name="services[deinstall]" id="services_deinstall" class="field">
                                </div>
                            </div>
                        </div>

                        <div class="field_group">
                            <h2>Остальное</h2>
                            <div class="inner">
                                <div class="field_area">
                                    <label for="client_file">Файлы от клиента (фото усопшего, документы...)</label>
                                    <div class="err">@error('client_file') {{ $message }} @enderror</div>
                                    <input type="file" name="client_file" id="client_file" class="field">
                                </div>
                                <div class="field_area">
                                    <label for="deadline_date">Исполнить до (ДД.ММ.ГГГГ):</label>
                                    <div class="err">@error('deadline_date') {{ $message }} @enderror</div>
                                    <input type="text" name="deadline_date" id="deadline_date" placeholder="" value="" class="field datemask">
                                </div>
                                <div class="field_area">
                                    <label for="comment">Комментарий к заказу</label>
                                    <div class="err">@error('comment') {{ $message }} @enderror</div>
                                    <textarea name="comment" id="comment" rows="4" class="field"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="field_group">
                            <h2>Смета</h2>
                            <table class="list" style="margin: 0">
                                <tr>
                                    <th>Наименование</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                    <th>Итого</th>
                                </tr>
                                <tr>
                                    <td>Гравировка</td>
                                    <td class="tac">2</td>
                                    <td class="tac">500</td>
                                    <td class="tac">1000</td>
                                </tr>
                                <tr>
                                    <td>Модель</td>
                                    <td class="tac">1</td>
                                    <td class="tac">1000</td>
                                    <td class="tac">1000</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="payment" id="payment" class="field" placeholder="Платеж"></td>
                                    <td><input type="text" name="total_correct" id="total_correct" class="field" placeholder="Корректировка"></td>
                                    <td colspan="2" class="tac">Итого: <strong class="digit">0</strong> ₽</td>
                                </tr>
                            </table>
                        </div>

                        {{--
                        <div class="err">@error('payment') {{ $message }} @enderror</div>
                        <div class="err">@error('total_correct') {{ $message }} @enderror</div>
                        <div class="err">@error('mm_model') {{ $message }} @enderror</div>
                        <div class="err">@error('mm_model_size') {{ $message }} @enderror</div>
                        <div class="err">@error('mm_material') {{ $message }} @enderror</div>
                        <div class="err">@error('mm_details') {{ $message }} @enderror</div>
                        <div class="err">@error('eskiz') {{ $message }} @enderror</div>
                        <div class="err">@error('user_id') {{ $message }} @enderror</div>
                        --}}

                        <!-- Поля конструктора -->
                        <div id="constructor_rows">
                            <input type="hidden" name="mm_model">
                            <input type="hidden" name="mm_model_size">
                            <input type="hidden" name="mm_material">
                            <input type="hidden" name="mm_details">
                        </div>

                        <!-- Готово -->
                        <input type="hidden" name="eskiz">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="status_id" value="1">
                        <input type="submit" class="btn" value="Создать">

                    </form>

                </div>

                <div class="tab-item c2">
                    <div id="constructor">
                        <div class="canvas_area">
                            <div class="inner">
                                <canvas id="canvas"></canvas>
                            </div>
                            <div class="instruction">
                                <h2>Инструкция</h2>
                                <p>В правом верхнем углу этого холста, находится "панель инструментов"</p>
                                <ol>
                                    <li>Самая верхняя иконка, предоставляет выбор <strong>модели памятника</strong> и затем последует выбор <strong>материала</strong>.</li>
                                    <li>Нижеследующие иконки можно выбирать в любой порядке и добавлять любое количество элементов из них.</li>
                                </ol>
                                <p>По завершении конструирования и заполнения в этой вкладке, нажимаете "<strong>Сохранить эскиз</strong>" и он прикрепится к создаваемому заказу и расчитается в смете. Также можно отдельно "<strong>Скачать эскиз</strong>"</p>
                            </div>
                            <div class="tool_area">
                                <div class="tool model cpp" data-pp="model">
                                    <img src="{{ asset('/static/images/ico/constructor/model.svg') }}" alt="" class="bimg">
                                </div>
                                <div class="tool material cpp" data-pp="material" style="display: none">
                                    <img src="{{ asset('/static/images/ico/constructor/material.svg') }}" alt="" class="bimg">
                                </div>
                                <div class="tool portrait cpp" data-pp="portrait">
                                    <img src="{{ asset('/static/images/ico/constructor/portrait.svg') }}" alt="" class="bimg">
                                </div>
                                <div class="tool grave cpp" data-pp="grave">
                                    <img src="{{ asset('/static/images/ico/constructor/grave.svg') }}" alt="" class="bimg">
                                </div>
                            </div>
                        </div>
                        <div class="material_area">

                            <div class="field_group model_size open" style="display: none">
                                <h2>Размер стеллы</h2>
                                <div class="field_area inner">
                                    @foreach($sizeList as $sizeType => $sizeItem)
                                        <select name="mm_model_size[{{ $sizeType }}]" id="mm_model_size{{ $sizeType }}" class="field model_size" style="display: none" disabled>
                                            <option value="">— Выбрать:</option>
                                            @foreach($sizeItem as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    @endforeach
                                </div>
                            </div>

                            <div class="field_group monument-text">
                                <h2>Текст для памятника</h2>
                                <div class="inner">

                                    <div class="font_area">
                                        <div class="field_area c1">
                                            <!-- <label for="font_select">Шрифт</label> -->
                                            <select name="font_select" id="font_select" class="field">
                                                <option value="Times New Roman" data-weight="bold">Times New Roman, крупный</option>
                                                <option value="Times New Roman" data-weight="bold" data-style="italic" selected="">Times New Roman, пропись</option>
                                                <option value="CyrillicOld" data-weight="bold">Кириллица старая, крупный</option>
                                                <option value="Arial" data-weight="bold">Arial, крупный</option>
                                                <option value="AcademyC">Академия</option>
                                                <option value="AnastasiaScript">Анастасия</option>
                                                <option value="Asessor">Оценщик</option>
                                                <option value="Carolina">Каролина</option>
                                            </select>
                                        </div>
                                        <div class="field_area c2">
                                            <!-- <label for="font_size">Размер</label> -->
                                            <input type="number" name="font_size" id="font_size" value="25" size="2" class="field">
                                        </div>
                                        <div class="field_area c3 nomb">
                                            <!-- <label for="text_align">Выравнивание</label> -->
                                            <div id="text_align" class="text_align">
                                                <img src="{{ asset('/static/images/ico/constructor/text-align/left.svg') }}" alt="" class="text left active" data-align="left">
                                                <img src="{{ asset('/static/images/ico/constructor/text-align/center.svg') }}" alt="" class="text center" data-align="center">
                                                <img src="{{ asset('/static/images/ico/constructor/text-align/right.svg') }}" alt="" class="text right" data-align="right">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-area deceased" data-name="deceased">
                                        <div class="tab label">
                                            <div class="tab-item c1" data-count="1">Усопший 1</div>
                                            <img src="{{ asset('/static/images/ico/add.png') }}" alt="" class="add deceased">
                                        </div>
                                        <div class="tab page">
                                            <div class="tab-item c1">
                                                <div class="field_area">
                                                    <label for="lastname">Фамилия</label>
                                                    <input type="text" name="lastname" id="lastname" class="field text">
                                                    <img src="{{ asset('/static/images/ico/add.png') }}" alt="" class="add text">
                                                </div>
                                                <div class="field_area">
                                                    <label for="firstname">Имя</label>
                                                    <input type="text" name="firstname" id="firstname" class="field text">
                                                    <img src="{{ asset('/static/images/ico/add.png') }}" alt="" class="add text">
                                                </div>
                                                <div class="field_area">
                                                    <label for="fathername">Отчество</label>
                                                    <input type="text" name="fathername" id="fathername" class="field text">
                                                    <img src="{{ asset('/static/images/ico/add.png') }}" alt="" class="add text">
                                                </div>
                                                <div class="date_area">
                                                    <div class="field_area c1">
                                                        <label for="birth_date">Дата рождения</label>
                                                        <input type="text" name="birth_date" id="birth_date" class="field text">
                                                        <img src="{{ asset('/static/images/ico/add.png') }}" alt="" class="add text">
                                                    </div>
                                                    <div class="field_area c2 nomb">
                                                        <label for="death_date">Дата смерти</label>
                                                        <input type="text" name="death_date" id="death_date" class="field text">
                                                        <img src="{{ asset('/static/images/ico/add.png') }}" alt="" class="add text">
                                                    </div>
                                                </div>
                                                <div class="field_area">
                                                    <label for="epitafia">Эпитафия</label>
                                                    <textarea name="epitafia" id="epitafia" cols="3" class="field text"></textarea>
                                                    <img src="{{ asset('/static/images/ico/add.png') }}" alt="" class="add text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="field_group">
                                <h2>Дополнения</h2>
                                <div class="inner">
                                    <div class="field_area inline">
                                        <input type="checkbox" name="tombstone" id="tombstone" data-pp="tombstone" class="cpp">
                                        <label for="tombstone">Цветник / надгробие <span class="product_name"></span></label>
                                    </div>
                                    <div class="field_area inline">
                                        <input type="checkbox" name="fence" id="fence" data-pp="fence" class="cpp">
                                        <label for="fence">Ограда <span class="product_name"></span></label>
                                    </div>
                                    <div class="field_area inline">
                                        <input type="checkbox" name="vase" id="vase" data-pp="vase" class="cpp">
                                        <label for="vase">Вазы <span class="product_name"></span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="field_group">
                                <h2>Облицовка</h2>
                                <div class="inner">
                                    <div class="field_area">
                                        <label for="face_m2">Площадь (м<sup>2</sup>)</label>
                                        <input type="number" name="face_m2" id="face_m2" class="field">
                                        <img src="{{ asset('/static/images/ico/add.png') }}" alt="" class="add face">
                                    </div>
                                    <div class="field_area">
                                        <select name="facing" id="facing" class="field">
                                            <option value="0" selected></option>
                                            @foreach($productList->where('category_id', 23) as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }} / {{ $product->price }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="output_area">
                                <input type="submit" value="Сохранить эскиз" class="btn" onclick="convert('code')">
                                <input type="submit" value="Скачать эскиз" class="btn" onclick="convert('file')">
                            </div>

                        </div>
                    </div>
                </div><!-- tab-item c2 -->

            </div>
        </div>

</div>
@endsection
