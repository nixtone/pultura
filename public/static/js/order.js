$(document).ready(function() {

    /*

    https://fabricjs.github.io/api/

    -------------------------------------------
    # Материалы:
    https://habr.com/ru/articles/162367/ (Знакомимся с Fabric.js. Часть 1-я)
    https://habr.com/ru/articles/167119/ (Знакомимся с Fabric.js. Часть 2-я)
    https://habr.com/ru/articles/254763/ (Знакомимся с Fabric.js. Часть 3-я)
    https://habr.com/ru/articles/257401/ (Знакомимся с Fabric.js. Часть 4-я)

    https://www.youtube.com/watch?v=mghXNWvVGTs&list=PLMz4kNt6Rs7gVDL18CmALxyykoDyhDgN0&index=6 (Fabric.js Учебное пособие / Ускоренный курс1)

    https://stackoverflow.com/questions/20462307/fabric-js-how-to-deselect-one-or-multiple-objects-on-canvas (Fabric.js: как отменить выделение одного или нескольких объектов на canvas?)
    https://translated.turbopages.org/proxy_u/en-ru.ru.8293cca6-66c0de26-29b19924-74722d776562/https/stackoverflow.com/questions/24156592/how-to-set-repeating-background-image-for-a-canvas-in-fabric-js?rq=3 (How to set repeating background image for a canvas in Fabric JS?)

    -------------------------------------------
    # Образцы:
    https://konstruktor-pamyatnikov.ru/demo/
    https://shop.gran-tech.ru/construktor.php
    https://postament.ru/constructor/
    https://monument-nd.ru/konstruktor-pamjatnikov-na-mogilu/
    https://40dney.ru/oformi/?ysclid=lzn7lxf3rs72064001

    */

    // Создаем холст
    const initCanvas = (id) => {
        return new fabric.Canvas(id, {
            width: 920,
            height: 700,
            backgroundColor: '#ccc'//'#CCC'
        });
    }

    // Назначаем фон
    const back = (url) => {
        fabric.Image.fromURL(url, (img) => {
            canvas.backgroundImage = img;
            canvas.backgroundVpt = false;
            canvas.renderAll(); // centerObject(img).
        });
    }

    // Гравировки
    // https://fabricjs.github.io/api/classes/fabricimage/
    const image = (src, id, stroke = {color: '#CCC', width: 3}) => { //
        fabric.Image.fromURL(src, function(img) {
            img.id = id;
            img.top = 10;
            img.left = 10;
            img.scaleToWidth(100);
            img.scaleToHeight(100);
            //img.backgroundColor = '#808080';
            img.stroke = stroke.color;
            img.strokeWidth = stroke.width;
            //img.stroke = '#ccc';
            //img.strokeWidth = 10;
            img.setControlsVisibility({
                'tl':true,
                'tr':false,
                'bl':true,
                'br':true,
                'ml':false,
                'mt':false,
                'mr':false,
                'mb':false,
                'mtr':true
            });
            canvas.add(img);
        });
        canvas.renderAll();
    }

    // Текстовое поле
    // https://fabricjs.github.io/api/classes/textbox/
    const text = (text, id, align = 'left', font = { name: 'Times New Roman', size: 25 }) => {
        let textBox = new fabric.Textbox(text, {
            id: id,
            left: 10,
            top: 10,
            width: 150,
            fontSize: font.size,
            fontFamily: font.name,
            fontWight: font.weight ?? 'normal',
            fontStyle: font.style ?? 'normal',
            textAlign: align,
            // lineHeight: font.lineHeight,
            fill: '#fff',
            editable: false
        });
        canvas.add(textBox).setActiveObject(textBox);
    }

    // Кнопка удаления
    const addDeleteBtn = (x, y) => {
        $(".deleteBtn").remove();
        $("#constructor > .canvas_area > .inner").append('<div class="delete_btn" style="top:'+(y-10)+'px; left:'+(x-10)+'px;"><img src="/static/images/ico/delete.svg" class="bimg"></div>');
    }

    // Инициализация
    const canvas = initCanvas('canvas');
    // смета
    let conList = {
        model: [],
        size: 0,
        material: 0,
        portrait: [],
        grave: [],
        text: {},
        face: [], // облицовка
        // дополнения
        tombstone: 0,
        fence: 0,
        vase: 0,
    };

    /* ----------------------------------------- */

    // Кнопка удаления
    canvas.on('object:selected',function(event){
        addDeleteBtn(
            event.target.oCoords.tr.x,
            event.target.oCoords.tr.y
        );
    });
    canvas.on('object:added',function(event){
        addDeleteBtn(
            event.target.oCoords.tr.x,
            event.target.oCoords.tr.y
        );
        console.log(event);
    });
    canvas.on('mouse:down',function(event){
        if(!canvas.getActiveObject()) {
            $(".delete_btn").remove();
        }
        else {
            addDeleteBtn(
                event.target.oCoords.tr.x,
                event.target.oCoords.tr.y
            );
        }
    });
    canvas.on('object:modified',function(event){
        addDeleteBtn(
            event.target.oCoords.tr.x,
            event.target.oCoords.tr.y
        );
    });
    canvas.on('object:scaling',function(event){
        $(".delete_btn").remove();
    });
    canvas.on('object:moving',function(event){
        $(".delete_btn").remove();
    });
    canvas.on('object:rotating',function(event){
        $(".delete_btn").remove();
    });
    $(document).on('click',".delete_btn",function(){

        // Название поля и значение
        const delID = canvas.getActiveObject().id;
        let fieldName, fieldValue;
        [fieldName, fieldValue] = delID.split(":");
        fieldValue = parseInt(fieldValue);

        // Удаляем из сметы
        if(fieldName.includes("text", 0)) { // текстовые поля
            // данные
            let key, textFieldName;
            [key, textFieldName] = fieldName.split(".");
            let tabArea = $(".tab-area.deceased .tab.page .tab-item.c" + fieldValue + " .field_area." + textFieldName);
            // удаляем из сметы
            delete conList[key][fieldValue][textFieldName];
            // раскрытие поля
            tabArea.find(".field").attr('disabled', false);
            tabArea.find(".add.text").removeClass('disabled');
        }
        else { // остальные поля
            const delIndex = conList[fieldName].indexOf(fieldValue); // ищем удаляемый productID среди значений
            conList[fieldName].splice(delIndex,1);
        }

        // Удаляем элемент с холста
        if(canvas.getActiveObject()) {
            canvas.remove(canvas.getActiveObject());
            $(".delete_btn").remove();
        }

    });

    /* ----------------------------------------- */




    // http://127.0.0.1:8000/
    //back("/storage/product/147/1.png");
    /*
        //
        $(".field.text").keyup(function(event) {
            // console.log($(this).val());
            let textVal = $(this).val();
            text(textVal);
        });
        */

    /*
    function test1() {
        canvas.on('selection:cleared', function() {
            console.log('Снятие 1');
        });
    }
    console.log(canvas.getActiveGroup());
    */


    /* ----------------------------------------- */

    // Переключатель группы полей
    $("#constructor h2").click(function(event) {
        $(this).closest(".field_group").find(".inner").slideToggle();
    });

    /* ----------------------------------------- */

    // Попап

    // Закрытие
    function closePopup() {
        $("body").removeClass('blockScroll');
        $(".overlay").fadeOut(150);
    }
    // Открытие
    $(".cpp").click(function(event) {
        event.preventDefault();
        // Uncheck дополнений
        if($(this).closest('.field_area').hasClass('checked')) {
            $(this).closest('.field_area').removeClass('checked').find(".product_name").html('');
            // удаление из сметы
            conList[$(this).data('pp')] = 0;
            return;
        }
        //
        $(".overlay .inner > *").hide();
        $(".overlay, .overlay ." + $(this).data('pp')).fadeIn(150);
        // Стили
        let maxHeight = $("body").height() > 900 ? 900 : $("body").height();
        $("body").addClass('blockScroll');
        $(".popup, .grid").css('max-height', maxHeight);
    });
    // Закрытие при клике в сторону
    $(".overlay").click(function(event) {
        if(!$(".popup").is(event.target) && $(".popup").has(event.target).length === 0 || event.target.className == "close") closePopup();
    });
    // Выбор наименования из Popup
    $(".window .item").click(function(event) {
        // Скрытие инструкции TODO: переставить на любое добавление на холст
        $(".instruction").hide();
        // Сбор данных
        const window = $(this).closest('.window');
        let stroke = {
            color: '#CCC',
            width: 3
        };
        const item = {
            field: window.data('field'),
            id: parseInt($(this).data('id')),
            // price: $(this).data('price'),
            name: $(this).data('name'),
            catID: $(this).data('cat'),
            // catName: $(this).closest(".tab-area").find(".tab.label .tab-item.active").text(),
            negative: $(this).data('negative'),
            constructor: window.data('construct'),
        }
        const canvasElementID = item.field+":"+item.id;

        // Сохранение новых данных
        switch(item.field) {
            case 'model': {

                // Раскрытие размеров
                const vertical = 30,
                      horizontal = 31;
                $("#constructor .field_group.model_size").show();
                $("#mm_model_size" + (item.catID == 2 ? vertical : horizontal)).show().attr('disabled', false);
                $("#mm_model_size" + (item.catID == 2 ? horizontal : vertical)).hide().attr('disabled', true);

                // Добавляем в смету модель
                conList[item.field].push(item.id);
                // Добавляем на холст модель
                image(item.negative, item.field+":"+item.id, stroke);
                // Открыть материал и остановиться
                $(".tool.material").trigger('click');
                return;
            } break;
            case 'material': {
                // Добавляем в смету
                conList[item.field] = item.id;
            } break;
            case 'portrait': {
                // Задаем рамку элементу на холсте
                stroke = {
                    color: '#CCC',
                    width: 0
                };
                // Добавляем в смету
                conList[item.field].push(item.id);
            } break;
            case 'grave': {
                // Задаем рамку элементу на холсте
                stroke = {
                    color: '#CCC',
                    width: 0
                }
                // Добавляем в смету
                conList[item.field].push(item.id);
            } break;
            case 'tombstone':
            case 'fence':
            case 'vase': {
                $(".field_area.tombstone").addClass('checked');
                $(".field_area.tombstone .product_name").html(item.name);
                // Добавляем в смету
                conList[item.field] = item.id;
            } break;
        }

        // Добавление элемента на холст
        switch(item.constructor) {
            case 'back': {
                back(item.negative);
            } break;
            case 'image': {
                image(item.negative, canvasElementID, stroke); // , stroke
            } break;
        }

        // Закрываем по итогу выбора
        closePopup();
    });

    // Размер
    $(".field.model_size").change(function(event) {
        // Запись в смету
        conList.size = parseInt($(this).find("option:selected").val());
    });

    // Текста
    // выбор выравнивания
    $(".text_align .text").click(function(event) {
        $(this).addClass('active').siblings().removeClass('active');
    });
    // добавление текста на холст
    $(".field_group.monument-text").on('click', '.add.text', function() {
        // имя и значение
        const textField = $(this).closest('.field_area').find('.field');
        const field = {
            name: textField.attr('name'),
            val: textField.val()
        }
        // уже добавлено или пустое
        if($(this).hasClass('disabled') || field.val == '') return;
        // деактив
        textField.attr('disabled', true);
        $(this).addClass('disabled');
        // шрифт
        const align = $(".text_align .text.active").data('align');
        const fontSelected = $("#font_select").find(':selected');
        const font = {
            name: fontSelected.val(),
            size: $("#font_size").val(),
            weight: fontSelected.data('weight'),
            style: fontSelected.data('style'),
            // lineHeight: $("#line_height").val(),
        };
        // добавляем в смету
        const activeCount = parseInt($(".field_group.monument-text .tab.label .tab-item.active").data('count'));
        if(!conList.text[activeCount]) conList.text[activeCount] = {};
        conList.text[activeCount][field.name] = field.val;
        // добавляем на холст
        text(field.val, "text." + field.name + ":" + activeCount, align, font);
    });

    // Новая группа текстовых полей
    $(".tab-area.deceased .add.deceased").click(function(event){
        // номер
        let lastCount = parseInt($(".tab-area.deceased .tab.label .tab-item").last().data('count'));
        let nextCount = ++lastCount;
        // отнимаем active
        $(this).closest('.tab-area').find('.tab-item').removeClass('active');
        // вкладка
        let tabLabel = $(".tab-area.deceased .tab.label .tab-item.c1")
            .clone()
            .removeClass('c1')
            .addClass("active c" + nextCount)
            .attr('data-count', nextCount);
        let [tabName,tabCount] = tabLabel.text().split(" ");
        tabLabel.text(tabName + " " + nextCount);
        // страница
        let tabPage = $(".tab-area.deceased .tab.page .tab-item.c1")
            .clone()
            .removeClass('c1')
            .addClass("active c" + nextCount);
        // очистка
        tabPage.find(".field").val('').attr('disabled', false);
        tabPage.find(".add.text").removeClass('disabled');
        // добавляем
        $(".tab-area.deceased .tab.label .add.deceased").before(tabLabel);
        $(".tab-area.deceased .tab.page").append(tabPage);
    });

    // Добавление "облицовки"
    $(".add.face").click(function(event) {
        // Сбор данных
        const faceOption = $("#facing").find(':selected');
        const face = {
            m2: parseInt($("#face_m2").val()),
            facing: parseInt(faceOption.val())
        }
        let faceName, facePrice;
        [faceName, facePrice] = faceOption.html().split(" / ");
        // добавляем в смету
        conList['face']['m2'] = face.m2;
        conList['face']['facing'] = face.facing;
        // выводим выбор
        $(".field_group.face .result").html("- " + faceName + " (" + face.m2 + "м<sup>2</sup>)");
    });


    /* ----------------------------------------- */

    // Запрос сметы
    $("#order_estimate_btn").click(function(event) {
        event.preventDefault();

        //
        $("#price_list").val(JSON.stringify(conList));

        //
        $.post('/order/price', $("#order_form").serialize(), function(data) {
            console.log(data);

            // Показать смету
            $(".field_group.estimate").show().find('.label_tr');

            // Наполнение сметы
            $.each(data.order, function(key, value){
                console.log(key);
                /*
                model
                grave
                text

                material +
                size +
                tombstone +
                fence +
                vase +
                */
                let new_tr;
                switch(key) {
                    /*
                    case '': {
                        new_tr = '';
                    } break;
                    */
                    case 'material':
                    case 'size':
                    case 'tombstone':
                    case 'fence':
                    case 'vase': {
                        new_tr = '<tr class="'+key+'"><td>' + value.label + '</td><td class="tac">-</td><td class="tac">-</td><td class="tac">' + value.price + '</td></tr>';
                    } break;
                }
                $(".field_group.estimate .total_tr").before(new_tr);

            });

            // Итого
            $(".field_group.estimate .price_td .digit").html(data.price);

        });

        //console.log(conList.serialize());
        //console.log();
        //console.log($("#eskiz_field").val());
    });

});
