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
    $(".datemask").mask('99.99.9999');

    // Попап
    $(".cpp").click(function(event) {
        event.preventDefault();
        $(".overlay .inner > *").hide();
        $(".overlay, .overlay ."+$(this).data('pp')).fadeIn(150);
    });
    $(".overlay").click(function(event) {
        if(!$(".popup").is(event.target) && $(".popup").has(event.target).length === 0 || event.target.className == "close") $(".overlay").fadeOut(150);
    });
    $(".overlay .preview").click(function(event) {
        $(this).addClass('active').siblings().removeClass('active');
    });

    //
    $(".field_group.user_choose input[name='choose_client']").click(function(event) {
        // console.log($(this).val());
        // $(".field_group.user_choose .row").removeClass('active');
        $(".field_group.user_choose .row").removeClass('active').parent().find(".row.c" + $(this).val()).addClass('active');
    });


    // Цена с пробелами
    function priceFormat(number, decimals = 0, dec_point = '', thousands_sep = ' ') {  // Format a number with grouped thousands
        var i, j, kw, kd, km;
        if( isNaN(decimals = Math.abs(decimals)) )decimals = 2;
        if( dec_point == undefined ) dec_point = ",";
        if( thousands_sep == undefined ) thousands_sep = ".";
        i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
        j = (j = i.length) > 3  ? j % 3 : 0 ;
        km = (j ? i.substr(0, j) + thousands_sep : "");
        kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
        kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
        return km + kw + kd;
    }


});
