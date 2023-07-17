$(document).ready(function() {

    // Снимаем чебоксы
    /*
    $("input[type='checkbox']").each(function(index, el) {
        $(this).prop('checked', false);
    });
    */

    // Собираем вид памятника
    //console.log($(".window.material .tab.page .tab-item .item img").attr('src'));
    //console.log($(".window.material .tab.page .tab-item .item img").attr('src'));


    // Выбор клиента
    $(".field_group.user_choose input[name='choose_client']").click(function(event) {
        $(".field_group.user_choose .row").removeClass('active').parent().find(".row.c" + $(this).val()).addClass('active');
    });

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
        // Заполняем поле
        $("#"+field).val(id);
        // Дополнительные действия
        switch(field) {
            case 'model': {
                // Отображаем выбор в эскизе
                $("#constructor .negative").css('background-image', 'url('+imagePath+'/'+$(this).data('negative')+')');
                // Отображение выбора размера модели
                $(".field_area.model-size_area .field.model-size")
                    .removeAttr('name')
                    .hide()
                    .closest(".field_area")
                    .find(".field.model-size.c"+catID)
                    .attr('name', 'model_size')
                    .show();
                $(".field_area.model-size_area").show();
                // Изменение размера памятника в эскизе
                $(".field_area.model-size_area .field.model-size.c"+catID).change(function(event) {
                    let selectedOption = $(this).find("option:selected");
                    let W = selectedOption.data('w');
                    let H = selectedOption.data('h');
                    let Wm, Hm, Wp;
                    switch(catID) {
                        case 2: {
                            Wm = W * 2;
                            Hm = H * 8;
                            Wp = W * 2 + 20;
                        } break;
                        case 3: {
                            Wm = 1;
                            Hm = 1;
                            Wp = 1;
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
                /*
                let selectedOption = $(".field_area.model-size_area .field.model-size.c"+catID+" option:first");
                let W = selectedOption.data('w');
                let H = selectedOption.data('h');
                let Wm, Hm, Wp;
                switch(catID) {
                    case 2: {
                        Wm = W * 2;
                        Hm = H * 8;
                        Wp = W * 2 + 20;
                    } break;
                    case 3: {
                        Wm = 1;
                        Hm = 1;
                        Wp = 1;
                    } break;
                }
                $("#constructor .monument.part").css({
                    width: Wm + 'px',
                    height: Hm + 'px'
                });
                $("#constructor .postament.part").css({
                    width: Wp + 'px',
                });
                */
            } break;
            case 'material': {
                $("#constructor .part").css('background-image', 'url('+$(this).find(".preview").attr('src')+')');
            } break;
            case 'portrait': {
                $("#constructor .item.portrait .preview").attr('src', '/'+$(this).data('negative'));
            } break;
            //
        }
    });

    /*
    TODO: Допилить чекбоксы 2/2
    $("#order.new .ppField").click(function(event) {
        $(this).closest(".cpp").trigger('click');
    });
    */

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

    // target elements with the "draggable" class
    interact('#constructor .item').draggable({
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
