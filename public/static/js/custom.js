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


    // Подтверждение удаления
    $(".delete").click(function(event) {
        if($(this).hasClass('true')) {
            return;
        }
        if(confirm("Точно удаляем?")) {
            $(this).addClass('true').trigger('click');
        }
        else {
            event.preventDefault();
        }
    });

    // Табы
    $(".tab-area .tab").each(function(index, el) {
        $(this).find('.tab-item').first().addClass('active');
    });
    $(".tab-area").on('click', '.tab.label .tab-item', function(event) {
        let count = $(this).data('count');
        let tabAreaName = $(this).closest('.tab-area').data('name');
        $(".tab-area." + tabAreaName + " .tab").each(function(index, el) {
            $(this).find('.tab-item.c' + count).addClass('active').siblings().removeClass('active');
        });
    });

    // Поиск клиентов
    $(".presearch_field").keyup(function(event) {
        $.post('/client/presearch', $("#search_area").serialize(), function(arClient) {

            console.log(arClient);
            //return;

            $("#search_area .preresult").empty();
            arClient.forEach((client) => {
                $("#search_area .preresult").append('<a href="/client/' + client.id + '" class="result">' + client.name + " / " + client.phone + ' / ' + client.client_category.name + '</a>');
            });
        });
    });
    $("body").click(function(event) {
        if(
            !$("#search_area").is(event.target) &&
            $("#search_area").has(event.target).length === 0
        )
            $("#search_area .preresult").empty();
    }).find(".field.criterion").change(function(event) {
        let field_name = $(this).val();
        console.log(field_name);
        $("#search_area .field_area.c2 input").hide();
        $("#search_area .field." + field_name).show();
    });


});
