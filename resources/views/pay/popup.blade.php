<form action="" method="post" class="pay_add" id="pay_add" style="margin: -16px">

    <div class="field_group" style="margin: 0">
        <h2>Внесение платежа</h2>
        <div style="padding: 15px">

            <div class="field_area">
                <label for="amount">Сумма</label>
                <input type="text" name="amount" id="amount" class="field">
            </div>

            <div class="field_area">
                <label for="comment">Комментарий</label>
                <textarea name="comment" id="comment" rows="3" class="field"></textarea>
            </div>

            @csrf
            <input type="hidden" name="order_id" value="{{ $order_id }}">
            <input type="submit" value="Внести" class="btn">

        </div>
    </div>

</form>
