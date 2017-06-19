$(".btn-test").click(function(e){
    e.preventDefault();

    var placeId = $('input[name="place"]').val();
    
    var expirationDateDay = $('select[name="order_group[expirationDate][date][day]"]').val();
    var expirationDateMonth = $('select[name="order_group[expirationDate][date][month]"]').val();
    var expirationDateYear = $('select[name="order_group[expirationDate][date][year]"]').val();
    var expirationDateHour = $('select[name="order_group[expirationDate][time][hour]"]').val();
    var expirationDateMinute = $('select[name="order_group[expirationDate][time][minute]"]').val();

    var expirationDate = expirationDateYear + '-' + expirationDateMonth + '-' + expirationDateDay + 'T' + expirationDateHour + ':' + expirationDateMinute + ':00';
    
    $.get("../orderGroup/orderz", {place_id: placeId, expiration_date: expirationDate} , function(data, status){
        console.log(data)
    });
});