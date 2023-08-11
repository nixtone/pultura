$(document).ready(function() {

    // Маска телефона
    $(".phonemask").mask("+7 (999) 999-99-99").on('click', function (e) {
        var caret = e.target.selectionStart;
        var text = $(this).val();
        var lastChar = text.indexOf('_');
        if (lastChar < caret && lastChar !== -1) {
            $(this).caret(lastChar);
        }
    }).on('keydown', function (e) {
        if (e.keyCode === 39 || e.keyCode === 37) {
            var caret = e.target.selectionStart;
            var text = $(this).val();
            var lastChar = text.indexOf('_');
            if (lastChar <= caret && lastChar !== -1) {
                $(this).caret(lastChar - 1);
            }
        }
    });
    // Маска даты
    $(".datemask").mask('99.99.9999').on('click', function (e) {
        var caret = e.target.selectionStart;
        var text = $(this).val();
        var lastChar = text.indexOf('_');
        if (lastChar < caret && lastChar !== -1) {
            $(this).caret(lastChar);
        }
    }).on('keydown', function (e) {
        if (e.keyCode === 39 || e.keyCode === 37) {
            var caret = e.target.selectionStart;
            var text = $(this).val();
            var lastChar = text.indexOf('_');
            if (lastChar <= caret && lastChar !== -1) {
                $(this).caret(lastChar - 1);
            }
        }
    });

    // fancybox
    $('[data-fancybox="gallery"], [data-fancybox]').fancybox();

    // Смена статуса
    $("#status_selected").change(function(event) {
        let $this = $(this);
        // console.log($("#status_area").serialize());
        $.ajax({
            url: '/order/update/1',
            type: 'POST',
            dataType: 'json',
            data: $("#status_area").serialize(),
        })
        .always(function(data) {
            console.log(data);
        });
    });

    // Отмена выбора на чекбоксе
    function uncheck($this, ppWindowName) {
        if($this.prop('checked') == false) {
            $("label[for='"+ppWindowName+"']").removeClass('checked').closest(".field_area").find(".product_name").empty();
            switch(ppWindowName) {
                case 'model': {
                    $(".field_area.model-size_area").hide().find(".field.model-size").removeAttr('name');
                }
            }
            // TODO: не останавливает открытие popup
            return false;
        }
    }

    // Попап
    $(".cpp").click(function(event) {
        // Сбор данных
        let ppWindowName = $(this).data('pp');
        let $this = $(this);
        let maxHeight = $("body").height() > 900 ? 900 : $("body").height();

        $("body").addClass('blockScroll');
        $(".popup, .grid").css('max-height', maxHeight);
        //$(".tab-area .tab.page .tab-item .grid").height($(".tab-area .tab.page .tab-item").height());
        // Снятие чекбокса
        uncheck($this, ppWindowName);
        // Открытие
        $(".overlay .inner > *").hide();
        $(".overlay, .overlay ." + ppWindowName).fadeIn(150);
        // Закрытие
        $(".overlay").click(function(event) {
            if(!$(".popup").is(event.target) && $(".popup").has(event.target).length === 0 || event.target.className == "close") {
                $(".overlay").fadeOut(150);
                //
                $("body").removeClass('blockScroll');
                uncheck($this, ppWindowName);
            }
        });
    });

    // Табы
    $(".tab-area .tab").each(function(index, el) {
        $(this).find('.tab-item').first().addClass('active');
    });
    $(".tab-area .tab.label .tab-item").click(function(event) {
        let count = $(this).data('count');
        let tabAreaName = $(this).closest('.tab-area').data('name');
        $(".tab-area." + tabAreaName + " .tab").each(function(index, el) {
            $(this).find('.tab-item.c' + count).addClass('active').siblings().removeClass('active');
        });
    });

    /*
    $(".delete").click(function(event) {
        event.preventDefault();
        if(confirm("Точно удаляем?")) {
            $(this).trigger('click');
        }
    });
    */

});
