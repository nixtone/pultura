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

    // Попап
    $(".cpp").click(function(event) {
        let ppWindowName = $(this).data('pp');
        let $this = $(this);

        // TODO: Допилить чекбоксы 1/2
        //event.preventDefault();
        // console.log($this.find(".ppField").attr('name'));
        if($this.find("label").hasClass('checked')) {
            console.log("Нужно снять отметку");
            $this.find(".ppField").attr('checked', false);
            $this.find("label").removeClass('checked').find(".product_name").empty();
            //return false;
            event.stopPropagation();
        }
        /*
        if($this.find(".ppField").is(':checked')) {
            console.log("Нужно снять отметку");

            $(this).find("input[type='checkbox']").prop('checked', false);
            $(this).find("label").removeClass('checked').find(".product_name").empty();
            return;

        }
        */

        // Открытие
        $(".overlay .inner > *").hide();
        $(".overlay, .overlay ." + ppWindowName).fadeIn(150);
        // Закрытие
        $(".overlay").click(function(event) {
            if(!$(".popup").is(event.target) && $(".popup").has(event.target).length === 0 || event.target.className == "close") {
                // Снимаем галку
                $this.find(".ppField").prop('checked', false);
                $(".overlay").fadeOut(150);
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
