$(document).ready(function() {

    // Выбор наименований
    $(".window .item").click(function(event) {
        // Сбор данных
        let field = $(this).closest('.window').data('field');
        let id = $(this).data('id');
        let price = $(this).data('price');
        let name = $(this).data('name');
        let catID = $(this).data('cat');
        let catName = $(this).closest(".tab-area").find(".tab.label .tab-item.active").text();
        // Отражаем выбор в поле
        $("label[for='"+field+"']").addClass('checked').find(".product_name").text(': '+catName+' "'+name+'"');
        $("#"+field).prop('checked', true);
        $(".overlay").fadeOut(150);
        $("body").removeClass('blockScroll');
        // Заполняем поле
        $("#"+field).val(id);
        // Дополнительные действия
        switch(field) {
            case 'model': {
                // Отображаем выбор в эскизе
                $("#constructor .negative").css('background-image', 'url('+'/'+$(this).data('negative')+')');
                // Отображение выбора размера модели
                $(".field_area.model-size_area .field.model-size")
                    .removeAttr('name')
                    .hide()
                    .closest(".field_area")
                    .find(".field.model-size.c"+catID)
                    .attr('name', 'model_size')
                    .show();
                $(".field_area.model-size_area").show();
                // TODO: выбор первого размера
                // Изменение размера памятника в эскизе
                $(".field_area.model-size_area .field.model-size.c"+catID).show().change(function(event) {
                    let selectedOption = $(this).find("option:selected");
                    let W = selectedOption.data('w');
                    let H = selectedOption.data('h');
                    let Wm, Hm, Wp, WidthLimit = 445, HeightLimit = 252;
                    switch(catID) {
                        case 2: {
                            Wm = W * 2;
                            Hm = H * 8;
                            Wp = W * 2 + 20;
                        } break;
                        case 3: {
                            // решаю в лоб

                            switch(W) {
                                case 60: Wm = 320; break;
                                case 70: Wm = 400; break;
                                /*
                                case 80: Wm = 480; break;
                                case 100: Wm = 560; break;
                                case 120: Wm = 640; break;
                                */
                                case 80: Wm = WidthLimit; break;
                                case 100: Wm = WidthLimit; break;
                                case 120: Wm = WidthLimit; break;
                            }

                            switch(H) {
                                case 80: Hm = 240; break;
                                case 100: Hm = 280; break;
                                case 120: Hm = 320; break;
                                case 140: Hm = 400; break;
                                case 160: Hm = 480; break;
                            }
                            if(Hm > HeightLimit) Hm = HeightLimit;

                            Wp = Wm + 20;
                            if(Wp > WidthLimit) Wp = WidthLimit;
                        } break;
                    }
                    $("#constructor .monument.part").css({
                        width: Wm + 'px',
                        height: Hm + 'px'
                    });
                    $("#constructor .postament.part").css({
                        width: Wp + 'px',
                    });
                });
            } break;
            case 'material': {
                $("#constructor .part").css('background-image', 'url('+$(this).find(".preview").attr('src')+')');
            } break;
            case 'portrait': {
                $("#constructor .item.portrait .preview").attr('src', '/'+$(this).data('negative'));
            } break;
            case 'cross': {
                $("#constructor .item.cross .preview").attr('src', '/'+$(this).data('negative'));
            } break;
            case 'flower': {
                $("#constructor .item.flower .preview").attr('src', '/'+$(this).data('negative'));
            } break;
            case 'branch': {
                $("#constructor .item.branch .preview").attr('src', '/'+$(this).data('negative'));
            } break;
            case 'candle': {
                $("#constructor .item.candle .preview").attr('src', '/'+$(this).data('negative'));
            } break;
            case 'angel': {
                $("#constructor .item.angel .preview").attr('src', '/'+$(this).data('negative'));
            } break;
            case 'bird': {
                $("#constructor .item.bird .preview").attr('src', '/'+$(this).data('negative'));
            } break;
        }
    });

    // Запрос цены
    function getPriceRequest() {
        $.ajax({
            url: '/order/price',
            type: 'POST',
            dataType: 'json',
            data: $("#order_create").serialize(),
            beforeSend: function() {
                $(".preload").show();
            }
        })
        .always(function(data) {
            // console.log(data);
            $(".preload").hide();
            $("#order-total .digit").text(data.total);
            $("#total_amount").val(data.total);
            $("#price_list").val(data.serialize);
        });
    }
    getPriceRequest();
    // .priceRequest
    $(".priceRequestKeyup").keyup(function(event) { // .field_area .field.text
        getPriceRequest();
    });
    $(".priceRequestClick").click(function(event) { // .grid .item
        getPriceRequest();
    });
    $(".priceRequestChange").change(function(event) { // select
        getPriceRequest();
    });


    // Синхронизация с "Итого" при корректировке цены
    $("#total_amount").keyup(function(event) {
        $("#order-total .digit").text($(this).val());
    });



    // Текст для памятника
    $(".field.text").keyup(function(event) {
        // Сбор данных
        let fieldName = $(this).attr('name');
        let value = $(this).val();
        let fontSize = $(this).closest(".wrap").find(".field.size").val();
        let fontGroup = $(this).data('font');
        let fontFamily = $("#font_" + fontGroup).val();
        // Отражаем текст в эскизе
        $("#constructor .item." + fieldName).html(value).css('font-size', fontSize+'px');
        $("#constructor .item.font_" + fontGroup).css('font-family', fontFamily);
    });

    // Дефис между датами
    $("#defis").click(function() {
        if($(this).prop('checked')) {
            $("#constructor .item.birth_date").append('<span class="defis"> - </span>');
        }
        else {
            $("#constructor .defis").remove();
        }
    });

    // Выбор шрифта
    $(".font_select").change(function(event) {
        let fontGroup = $(this).data('font');
        let fontFamily = $(this).val();
        $("#constructor .item.font_"+fontGroup).css('font-family', fontFamily);
    });

    // Размер шрифта
    $(".field.size").change(function(event) {
        // Сбор данных
        let fieldName = $(this).closest(".wrap").find(".field.text").attr('name');
        let fontSize = $(this).val();
        // Меняем размер шрифта
        $("#constructor .item."+fieldName).css('font-size', fontSize+'px');
    });


    // Конструктор

    // Наведение на элемент
    $("#constructor .item").hover(function() {
        $(this).addClass('hover');
    }, function() {
        $(this).removeClass('hover');
    });

    // target elements with the "draggable" class
    interact('#constructor .item').resizable({
        // resize from all edges and corners
        edges: { left: true, right: true, bottom: true, top: true },

        listeners: {
            move (event) {
                var target = event.target
                var x = (parseFloat(target.getAttribute('data-x')) || 0)
                var y = (parseFloat(target.getAttribute('data-y')) || 0)

                // update the element's style
                target.style.width = event.rect.width + 'px'
                target.style.height = event.rect.height + 'px'

                // translate when resizing from top or left edges
                x += event.deltaRect.left
                y += event.deltaRect.top

                target.style.transform = 'translate(' + x + 'px,' + y + 'px)'

                target.setAttribute('data-x', x)
                target.setAttribute('data-y', y)
                //target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height)
            }
        },
        modifiers: [
            // keep the edges inside the parent
            interact.modifiers.restrictEdges({
                outer: 'parent'
            }),

            // minimum size
            interact.modifiers.restrictSize({
                min: { width: 10, height: 10 }
            })
        ],
        inertia: true
    }).draggable({
        // enable inertial throwing
        inertia: true,
        // keep the element within the area of it's parent
        modifiers: [
            interact.modifiers.restrictRect({
                restriction: 'parent',
                endOnly: true
            })
        ],
        // enable autoScroll
        autoScroll: true,
        listeners: {
            // call this function on every dragmove event
            move: dragMoveListener,
            // call this function on every dragend event
            end (event) {
                var textEl = event.target.querySelector('p')
                textEl && (textEl.textContent = 'moved a distance of ' +
                    (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
                        Math.pow(event.pageY - event.y0, 2) | 0)).toFixed(2) + 'px')
            }
        }
    })
    function dragMoveListener (event) {
        var target = event.target
        // keep the dragged position in the data-x/data-y attributes
        var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
        var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy
        // translate the element
        target.style.transform = 'translate(' + x + 'px, ' + y + 'px)'
        // update the posiion attributes
        target.setAttribute('data-x', x)
        target.setAttribute('data-y', y)
    }
    // this function is used later in the resizing and gesture demos
    window.dragMoveListener = dragMoveListener

});
