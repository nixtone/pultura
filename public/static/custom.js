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




    // Снятие всех чекбоксов при обновлении страницы
    $('input:checked').prop('checked', false);

    // Попап
    $(".cpp").click(function(event) {
        //event.preventDefault();

        // Сбор данных
        let $this = $(this);
        let maxHeight = $("body").height() > 900 ? 900 : $("body").height();
        let field = $this.attr('id');
        let label = $('label[for="'+field+'"]');

        // Регулятор отмечаний чекбоксов
        if($this.hasClass('ppField')) {
            $this.prop('checked', false);
            if(label.hasClass('checked')) {
                label.removeClass('checked').find(".product_name").text('');
                switch(field) {
                    case 'material': {
                        $("#constructor .part").css('background-image', 'unset');
                    } break;
                    case 'portrait': {
                        $("#constructor .item.portrait .preview").attr('src', '');
                    } break;
                    case 'cross': {
                        $("#constructor .item.cross .preview").attr('src', '');
                    } break;
                    case 'flower': {
                        $("#constructor .item.flower .preview").attr('src', '');
                    } break;
                    case 'branch': {
                        $("#constructor .item.branch .preview").attr('src', '');
                    } break;
                    case 'candle': {
                        $("#constructor .item.candle .preview").attr('src', '');
                    } break;
                    case 'angel': {
                        $("#constructor .item.angel .preview").attr('src', '');
                    } break;
                    case 'bird': {
                        $("#constructor .item.bird .preview").attr('src', '');
                    } break;
                }
                return;
            }
        }

        // Стили
        $("body").addClass('blockScroll');
        $(".popup, .grid").css('max-height', maxHeight);

        // естественное
        $(".overlay .inner > *").hide();
        $(".overlay, .overlay ."+$(this).data('pp')).fadeIn(150);
    });
    // естественное
    $(".overlay").click(function(event) {
        if(!$(".popup").is(event.target) && $(".popup").has(event.target).length === 0 || event.target.className == "close")
            $(".overlay").fadeOut(150);
        // Стили
        $("body").removeClass('blockScroll');
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
