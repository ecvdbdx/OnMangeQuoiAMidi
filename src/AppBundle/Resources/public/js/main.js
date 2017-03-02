$(".btn-test").click(function(e){
    var place_id = $('input[name="place"]').val();
    var user_id = $('input[name="user_id"]').val();
    console.log(place_id);
    $.get("../orderGroup/orderz", {place_id: place_id} , function(data, status){
        console.log(data)
    });
    e.preventDefault();
    console.log('ok');
});