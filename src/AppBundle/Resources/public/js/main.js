function tokenSuccess(success, data) {
    var div = $('.tokenInfo');
    if (success == true) {
        div.html("Votre token : " + data);
        div.addClass('success');
        div.removeClass('failed');
        copyButton(data);
    } else {
        div.html("Soit t'es pas connecté, soit t'es con");
        div.addClass('failed');
        div.removeClass('success');
    }
}

function copyButton(token) {
    var button = document.createElement("button");
    $(button).text('Copier le lien')
               .addClass('btn btn-primary copy');
    $(button).appendTo('form[name=order_group]');

    $(button).click(function(e) {
        e.preventDefault();

        var aux = document.createElement("input");
        aux.setAttribute("value", "/orderGroup/order?uid=" + token);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");

        document.body.removeChild(aux);

        $(button).text("Copied!");
    })
}


$(".btn-test").click(function(e){

    e.preventDefault();

    if ($('.tokenInfo').hasClass('success') || $('.tokenInfo').hasClass('failed')) {
        $('.tokenInfo').removeClass('success');
        $('.tokenInfo').removeClass('failed');
    }

    $('.copy').remove();

    var placeId = $('input[name="place"]').val();

    var expirationDateDay = $('select[name="order_group[expirationDate][date][day]"]').val();
    var expirationDateMonth = $('select[name="order_group[expirationDate][date][month]"]').val();
    var expirationDateYear = $('select[name="order_group[expirationDate][date][year]"]').val();
    var expirationDateHour = $('select[name="order_group[expirationDate][time][hour]"]').val();
    var expirationDateMinute = $('select[name="order_group[expirationDate][time][minute]"]').val();

    var expirationDate = expirationDateYear + '-' + expirationDateMonth + '-' + expirationDateDay + 'T' + expirationDateHour + ':' + expirationDateMinute + ':00';

    $.get("../orderGroup/orderz", {place_id: placeId, expiration_date: expirationDate} , function(data, status) {
        if (data) {
            tokenSuccess(true, data);
        } else {
            tokenSuccess(false);
        }
    });
});