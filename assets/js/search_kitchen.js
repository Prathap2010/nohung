var offset = 0;
$(document).ready(function(){

    if(is_payment_success == 1 || is_payment_failed == 1){
        $("#checkout-modal").modal("show");

        if(is_payment_success == 1){
            $("#title_payment_status").html("Payment Completed Successfully !");
        }else{
            $("#title_payment_status").html("Payment failed !");
        }
    }
    /* setTimeout(() => {
        loadkitchendata();
    }, 2000); */

    $("input[name=selectVariety]").click(function(){
        offset = 0;
        loadkitchendata();
    });

    $("#mealtype").change(function(){
        offset = 0;
        loadkitchendata();
    });

    $("#cuisinetype").change(function(){
        offset = 0;
        loadkitchendata();
    });

    /* $("#mealplan").change(function(){
        offset = 0;
        loadkitchendata();
    }); */

    $("#price").change(function(){
        offset = 0;
        loadkitchendata();
    });

    $("#rating").change(function(){
        offset = 0;
        loadkitchendata();
    });

    // initialize services
    /* const geocoder = new google.maps.Geocoder();
    const service = new google.maps.DistanceMatrixService();
    // build request
    const origin1 = { lat: 22.2648636003009, lng: 70.78461862561903 };
    const origin2 = "Mavdi Chowk, Rajkot";
    const destinationA = "Stockholm, Sweden";
    const destinationB = { lat: 50.087, lng: 14.421 };
    const request = {
        origins: [origin1, origin2],
        destinations: [destinationA, destinationB],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false,
    };
    // put request on page
    // console.log(JSON.stringify(request,null,2));

    service.getDistanceMatrix(request).then((response) => {
        // put response
        console.log(JSON.stringify(
          response,
          null,
          2
        ));
    }); */

    $(".order-time").each(function(){
        var id = parseInt($(this).attr("id").match(/\d+/));
        var datetime = $("#cancel_datetime_"+id).val();
        settimer(datetime, id);
    });
});
function loadkitchendata(){
    var itemtype = $("input[name=selectVariety]:checked").val();
    var mealtype = $("#mealtype").val();
    var cuisinetype = $("#cuisinetype").val();
    var mealplan = $("#mealplan").val();
    var price = $("#price").val();
    var rating = $("#rating").val();

    var cust_latitude = $("#cust_latitude").val();
    var cust_longitude = $("#cust_longitude").val();
    var cust_location = $("#foodieslocation").html();

    $.ajax({
        url: SITE_URL+'search-kitchen/loadkitchendata',
        type: 'POST',
        data: {offset:parseInt(offset),mealplan:mealplan,itemtype: itemtype,mealtype: mealtype,cuisinetype: cuisinetype,price: price,rating: rating,cust_location:cust_location, cust_latitude:cust_latitude, cust_longitude:cust_longitude},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".foodsectionsloadmorebtn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".foodsectionsloadmorebtn a").text('Loading...');
            if(parseInt(offset)==0){
                $('#kitchenlist').html("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+FRONT_IMAGES_URL+"loading-please-wait.gif'></div>");
            }else{
                $('#kitchenlist').append("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+FRONT_IMAGES_URL+"loading-please-wait.gif'></div>");
            }
        },
        success: function(response){

            $('#kitchenlist .loading-image').remove();

            $("#countkitchen").html(parseInt(response.totalrows));
            if(parseInt(offset)==0){
                $("#kitchenlist").html(response.html);
            }else{
                $("#kitchenlist").append(response.html);
            }
            offset = parseInt(offset) + parseInt(PER_PAGE_KITCHEN);
            
            if(parseInt(offset) >= parseInt(response.totalrows)){
                $(".foodsectionsloadmorebtn").hide();
            }else{
                $(".foodsectionsloadmorebtn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".foodsectionsloadmorebtn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            // $("#loader-image").html("")
            $(".foodsectionsloadmorebtn a").text('Load More');
        },
    });
}

function cancel_meal(orderitemsid) {

    if(orderitemsid > 0){
        $.ajax({
            url: SITE_URL+'search-kitchen/cancel-meal',
            type: 'POST',
            data: {orderitemsid:parseInt(orderitemsid)},
            dataType: 'json',
            // async: false,
            success: function(response){
                
                if(response == 1){
                    toastr.success('Meal cancelled suuccessfully !');

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }else{
                    toastr.error('Meal not cancel !');
                }
                
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
        });
    }
}
function settimer(datetime, id){
    var x = setInterval(function() {

        var countDownDate = new Date(datetime);
        countDownDate.setHours( countDownDate.getHours() - 4 );
        
        // Get today's date and time
        var now = new Date().getTime();
        
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
            
        // Time calculations for days, hours, minutes and seconds
        var hours = (Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).toString().padStart(2, 0);;
        var minutes = (Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).toString().padStart(2, 0);;
        var seconds = (Math.floor((distance % (1000 * 60)) / 1000)).toString().padStart(2, 0);
            
        if(hours >= 0 && minutes >= 0 && seconds >= 0){
            // Output the result in an element with id="demo"
            $("#cancel_time_"+id+" span:first").html(hours.toString().charAt(0));
            $("#cancel_time_"+id+" span:eq(1)").html(hours.toString().charAt(1));
            $("#cancel_time_"+id+" span:eq(3)").html(minutes.toString().charAt(0));
            $("#cancel_time_"+id+" span:eq(4)").html(minutes.toString().charAt(1));
            $("#cancel_time_"+id+" span:eq(6)").html(seconds.toString().charAt(0));
            $("#cancel_time_"+id+" span:eq(7)").html(seconds.toString().charAt(1));

            $("#order_"+id).show();
        }else{
            $("#order_"+id).hide();
        }
        
    }, 1000);
}

function add_favorite_kitchen(kitchen_id){
    
    $.ajax({
        url: SITE_URL+'kitchen-detail/addfavoritekitchen',
        type: 'POST',
        data: {kitchen_id: kitchen_id},
        dataType: 'json',
        // async: false,
        success: function(response){
            toastr.success("Kitchen added to favorite.");
            $("#favorite_kitchen_"+kitchen_id).attr("onclick","remove_favorite_kitchen("+kitchen_id+")").html('<img src="'+FRONT_IMAGES_URL+'bookmarks.svg" alt="" class="img-fluid">');
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}
function remove_favorite_kitchen(kitchen_id){
    
    $.ajax({
        url: SITE_URL+'kitchen-detail/removefavoritekitchen',
        type: 'POST',
        data: {kitchen_id: kitchen_id},
        dataType: 'json',
        // async: false,
        success: function(response){
            toastr.success("Kitchen removed to favorite.");
            $("#favorite_kitchen_"+kitchen_id).attr("onclick","add_favorite_kitchen("+kitchen_id+")").html('<i class="fa fa-bookmark-o" style="padding-top: 5px;color: #FCC647;"></i>');
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}