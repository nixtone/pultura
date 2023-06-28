@extends('design')

@section('title', 'Редактирование заказа: '.$order->id)
@section('content')
<div id="order" class="block">
    <form action="{{ route('order.update', $order->id) }}" method="post">
        @csrf
        @method('patch')

        <div class="field_group">
            <h2>Текст для памятника</h2>
            <div class="field_area">
                <label for="lastname">Фамилия</label>
                <input type="text" name="lastname" id="lastname" class="field" value="{{ $order->lastname }}">
            </div>
            <div class="field_area">
                <label for="firstname">Имя</label>
                <input type="text" name="firstname" id="firstname" class="field" value="{{ $order->firstname }}">
            </div>
            <div class="field_area">
                <label for="fathername">Отчество</label>
                <input type="text" name="fathername" id="fathername" class="field" value="{{ $order->fathername }}">
            </div>
            <div class="field_area">
                <table>
                    <tr>
                        <td><label for="birth_date">Дата рождения</label></td>
                        <td><label for="death_date">Дата смерти</label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="birth_date" id="birth_date" class="field datemask" value="{{ $order->birth_date }}"></td>
                        <td><input type="text" name="death_date" id="death_date" class="field datemask" value="{{ $order->death_date }}"></td>
                    </tr>
                </table>
            </div>
            <!-- <div class="advice">Если фокус стоит на выпадающем списке, можно выбирать его пукты стрелками ↑↓</div> -->
            <div class="field_area">
                <label for="epitafia">Эпитафия</label>
                <textarea name="epitafia" id="epitafia" cols="3" class="field">{{ $order->epitafia }}</textarea>
            </div>
        </div>

        <div class="field_area">
            <input type="submit" value="Редактировать заказ" class="btn">
        </div>
    </form>
</div>
@endsection
