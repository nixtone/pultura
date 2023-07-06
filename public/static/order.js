$(document).ready(function() {

    // Снимаем чебоксы
    $("input[type='checkbox']").each(function(index, el) {
        $(this).prop('checked', false);
    });

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
        let catName = $(this).closest(".tab-area").find(".tab.label .tab-item.active").text();
        // Отражаем выбор в эскизе
        $("label[for='"+field+"']").addClass('checked').find(".product_name").text(': '+catName+' "'+name+'"');
        $("#"+field).prop('checked', true);
        $(".overlay").fadeOut(150);
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
                textEl && (textEl.textContent = 'moved a distance of ' + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) + Math.pow(event.pageY - event.y0, 2) | 0)).toFixed(2) + 'px')
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