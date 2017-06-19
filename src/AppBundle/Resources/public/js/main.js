function tokenSuccess(success, data) {
    var div = $('.tokenInfo');
    if (success == true) {
        div.html("Votre token : " + data);
        div.addClass('success');
        div.removeClass('failed');
    } else {
        div.html("Soit t'es pas connecté, soit t'es con");
        div.addClass('failed');
        div.removeClass('success');
    }
}


$(".btn-test").click(function(e){

    e.preventDefault();

    var place_id = $('input[name="place"]').val();

    var expirationDateDay = $('select[name="order_group[expirationDate][date][day]"]').val();
    var expirationDateMonth = $('select[name="order_group[expirationDate][date][month]"]').val();
    var expirationDateYear = $('select[name="order_group[expirationDate][date][year]"]').val();
    var expirationDateHour = $('select[name="order_group[expirationDate][time][hour]"]').val();
    var expirationDateMinute = $('select[name="order_group[expirationDate][time][minute]"]').val();

    var expirationDate = expirationDateYear + '-' + expirationDateMonth + '-' + expirationDateDay + 'T' + expirationDateHour + ':' + expirationDateMinute + ':00';

    $.get("../orderGroup/orderz", {place_id: place_id} , function(data, status){
        if (data) {
            tokenSuccess(true, data);
        } else {
            tokenSuccess(false);
        }
    });
});