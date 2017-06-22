function tokenSuccess(success, data) {
    var div = $('.tokenInfo');
    if (success === true) {
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
    $(button).appendTo('form[name=appbundle_ordergroup]');

    $(button).click(function(e) {
        e.preventDefault();

        var aux = document.createElement("input");
        var routeToken = Routing.generate('order_group_show',{}, true);
        aux.setAttribute("value", routeToken + '/' + token);
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
    var expirationDate = $('input[name="appbundle_ordergroup[expirationDate]"]').val();
    var route = Routing.generate('create_order',{}, true);

    $.get(route,{place_id: placeId, expiration_date: expirationDate}, function(data, status) {
        if (data) {
            tokenSuccess(true, data);
        } else {
            tokenSuccess(false);
        }
    });
});
