@extends('design')

@section('title', 'Новый заказ')
@section('content')
<div id="order" class="new block">

    <div class="inner">
        <form method="post">

            <div class="field_group user_choose">
                <h2>Клиент</h2>

                <div class="field_area inline">
                    <input type="radio" name="choose_client" id="choose_client1" value="1" checked>
                    <label for="choose_client1">Новый</label>
                </div>
                <div class="row c1 active">
                    <div class="field_area">
                        <label for="client_name">Имя</label>
                        <input type="text" name="name" id="client_name" class="field">
                    </div>
                    <div class="field_area">
                        <label for="client_phone">Телефон</label>
                        <input type="text" name="phone" id="client_phone" class="field phonemask">
                    </div>
                </div>

                <div class="field_area inline">
                    <input type="radio" name="choose_client" id="choose_client2" value="2">
                    <label for="choose_client2">Зарегестированный</label>
                </div>
                <div class="row c2">
                    <div class="field_area">
                        <select name="client_id" class="field">
                            <option value=""></option>
                            <option value="">Петров Юрий Васильевич +7 (950) 123-45-67</option>
                            <option value="">Садовский Антон Григорьевич +7 (950) 123-45-67</option>
                            <option value="">Пень Юлия Климентьевна +7 (950) 123-45-67</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="field_group">
                <h2>Характеристики памятника</h2>
                <div class="field_area inline">
                    <input type="hidden" name="model">
                    <input type="submit" value="Выбрать модель">
                    <label for="">1</label>
                </div>
                <div class="field_area inline">
                    <input type="hidden" name="material">
                    <input type="submit" value="Выбрать материал">
                    <label for="">Диабаз</label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="has_portrait" id="has_portrait">
                    <label for="has_portrait">Наличие потрета</label>
                    <input type="file" name="" id="" class="field" multiple accept="image/jpeg, image/png, image/webp, image/gif">
                </div>
                <div class="field_area">
                    <label for="">Размеры стеллы:</label>
                    <select name="monument_size" class="field">
                        <option value="1">80 x 40 x 5</option>
                        <option value="2">100 x 50 x 5</option>
                        <option value="3">120 x 60 x 5</option>
                        <option value="4">80 x 40 x 8</option>
                        <option value="5">100 x 50 x 8</option>
                        <option value="5">120 x 60 x 8</option>
                        <option value="7">140 x 70 x 8</option>
                        <option value="8">80 x 40 x 10</option>
                        <option value="9">100 x 50 x 10</option>
                        <option value="10">120 x 60 x 10</option>
                        <option value="11">140 x 70 x 10</option>
                        <option value="12">160 x 80 x 10</option>
                        <option value="13">100 x 50 x 12</option>
                        <option value="14">120 x 60 x 12</option>
                        <option value="15">140 x 70 x 12</option>
                        <option value="16">160 x 80 x 12</option>
                    </select>
                </div>
            </div>

            <div class="field_group">
                <h2>Текст для памятника</h2>
                <!-- <div class="advice">Что бы не кликать каждый раз на следующее поле, можно нажимать "tab"</div> -->
                <div class="field_area">
                    <label for="lastname">Фамилия</label>
                    <input type="text" name="lastname" id="lastname" class="field">
                </div>
                <div class="field_area">
                    <label for="firstname">Имя</label>
                    <input type="text" name="firstname" id="firstname" class="field">
                </div>
                <div class="field_area">
                    <label for="fathername">Отчество</label>
                    <input type="text" name="fathername" id="fathername" class="field">
                </div>
                <div class="field_area">
                    <label for="birth_date">Дата рождения (день.месяц.год)</label>
                    <input type="text" name="birth_date" id="birth_date" class="field datemask">
                </div>
                <div class="field_area">
                    <label for="death_date">Дата смерти (день.месяц.год)</label>
                    <input type="text" name="death_date" id="death_date" class="field datemask">
                </div>
                <!-- <div class="advice">Если фокус стоит на выпадающем списке, можно выбирать его пукты стрелками ↑↓</div> -->
                <div class="field_area">
                    <label for="">Эпитафия</label>
                    <textarea name="epitafia" id="" cols="3" class="field"></textarea>
                </div>
            </div>

            <div class="field_group">
                <h2>Украшения</h2>
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
                    <label for="tombstone">Надгробие</label>
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="vasa" id="vasa">
                    <label for="vasa">Ваза</label>
                </div>
                <div class="field_area">
                    <label for="ograda">Ограда</label>
                    <select name="ograda" id="ograda" class="field">
                        <option value="">220 x 150</option>
                    </select>
                </div>
            </div>
            <div class="field_group">
                <h2>Услуги</h2>
                <div class="field_area">
                    <label for="delivery_km">Доставка (км)</label>
                    <input type="text" name="delivery_km" id="delivery_km" class="field">
                </div>
                <div class="field_area">
                    <label for="delivery_addr">Адрес доставки<br> (населенный пункт или кладбище)</label>
                    <input type="text" name="delivery_addr" id="delivery_addr" class="field">
                </div>
                <div class="field_area inline">
                    <input type="checkbox" name="install" id="install">
                    <label for="install">Установка</label>
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

            <!-- div.field_area>label -->

            <div class="field_area">
                <input type="submit" value="Создать заказ" class="btn">
            </div>
        </form>
        <div id="monument_constructor">
            <h2>Эскиз памятника</h2>
            <div class="sticky">
                <div class="preview"></div>
                <div id="order-total">Итого: <span class="digit">107305</span> &#8381;</div>
            </div>
        </div>
    </div>

</div>



@endsection
