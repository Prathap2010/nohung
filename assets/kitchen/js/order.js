var or_offset = ao_offset = uo_offset = oh_offset = 0;

$(document).ready(function(){
    load_order_requests();
    load_active_orders();
    load_upcoming_orders();
    load_order_history();

    $("#search_order_form").on("submit", function(e){
        e.preventDefault();
    });
});
$(document).on('keyup', '#search', function(){
    or_offset = ao_offset = uo_offset = oh_offset = 0;
    load_order_requests();
    load_active_orders();
    load_upcoming_orders();
    load_order_history();
});
function changeorderstatus(orderid, status, ordertype="trial"){
    
    if(orderid!=""){
        if(status==1){
            var label = "accept";
        }else if(status==2){
            var label = "reject";
        }else if(status==3 || status==0){
            var label = "ready to pick-up";
        }
        swal({
            title: "Are you sure you want to "+label+" this order ?",
            text: "",
            type: "warning",
            showCancelButton: true,   
            confirmButtonColor: "#FFA451",   
            confirmButtonText: "Yes",   
            closeOnConfirm: false }, 
            function(isConfirm){   
            if (isConfirm) {   
                $.ajax({
                    url: SITE_URL + "order/changeorderstatus",
                    data: {orderid:orderid,status:status,ordertype:ordertype},
                    // dataType: "json",
                    type: "POST",
                    success: function (data) {
                        if(data==1){
                            if(status==1 || status==2){
                                $("#orderbox"+orderid).remove();
                                ao_offset = oh_offset = 0;
                                load_active_orders();
                                load_order_history();
                            }else if(status==3 || status==0){
                                $("#ReadyToPickUpButotn_"+orderid).removeAttr("onclick");
                                $("#status_"+orderid).html("Ready to Picked-up");

                                oh_offset = 0;
                                load_order_history();
                            }
                            swal.close();
                        }
                    }
                });
            }
        });
    }
}
function load_order_requests(){
    var search = $("#search").val();

    $.ajax({
        url: SITE_URL+'order/load-order-requests',
        type: 'POST',
        data: {offset:parseInt(or_offset),search:search},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".or.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".or.load_more_btn a").text('Loading...');
            if(parseInt(or_offset)==0){
                $('#orlist').html("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+KITCHEN_IMAGES_URL+"loading-please-wait.gif'></div>");
            }else{
                $('#orlist').append("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+KITCHEN_IMAGES_URL+"loading-please-wait.gif'></div>");
            }
        },
        success: function(response){

            $('#orlist .loading-image').remove();

            if(parseInt(or_offset)==0){
                $("#orlist").html(response.html);
            }else{
                $("#orlist").append(response.html);
            }
            or_offset = parseInt(or_offset) + parseInt(PER_PAGE_ORDER);
            
            if(parseInt(or_offset) >= parseInt(response.totalrows)){
                $(".or.load_more_btn").hide();
            }else{
                $(".or.load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".or.load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".or.load_more_btn a").text('Load More');
        },
    });
}
function load_active_orders(){
    var search = $("#search").val();

    $.ajax({
        url: SITE_URL+'order/load-active-orders',
        type: 'POST',
        data: {offset:parseInt(ao_offset),search:search},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".ao.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".ao.load_more_btn a").text('Loading...');
            if(parseInt(ao_offset)==0){
                $('#aolist').html("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+KITCHEN_IMAGES_URL+"loading-please-wait.gif'></div>");
            }else{
                $('#aolist').append("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+KITCHEN_IMAGES_URL+"loading-please-wait.gif'></div>");
            }
        },
        success: function(response){

            $('#aolist .loading-image').remove();

            if(parseInt(ao_offset)==0){
                $("#aolist").html(response.html);
            }else{
                $("#aolist").append(response.html);
            }
            ao_offset = parseInt(ao_offset) + parseInt(PER_PAGE_ORDER);
            
            if(parseInt(ao_offset) >= parseInt(response.totalrows)){
                $(".ao.load_more_btn").hide();
            }else{
                $(".ao.load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".ao.load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".ao.load_more_btn a").text('Load More');
        },
    });
}
function load_upcoming_orders(){
    var search = $("#search").val();

    $.ajax({
        url: SITE_URL+'order/load-upcoming-orders',
        type: 'POST',
        data: {offset:parseInt(uo_offset),search:search},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".uo.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".uo.load_more_btn a").text('Loading...');
            if(parseInt(uo_offset)==0){
                $('#uolist').html("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+KITCHEN_IMAGES_URL+"loading-please-wait.gif'></div>");
            }else{
                $('#uolist').append("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+KITCHEN_IMAGES_URL+"loading-please-wait.gif'></div>");
            }
        },
        success: function(response){

            $('#uolist .loading-image').remove();

            if(parseInt(uo_offset)==0){
                $("#uolist").html(response.html);
            }else{
                $("#uolist").append(response.html);
            }
            uo_offset = parseInt(uo_offset) + parseInt(PER_PAGE_ORDER);
            
            if(parseInt(uo_offset) >= parseInt(response.totalrows)){
                $(".uo.load_more_btn").hide();
            }else{
                $(".uo.load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".uo.load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".uo.load_more_btn a").text('Load More');
        },
    });
}
function load_order_history(){
    var search = $("#search").val();

    $.ajax({
        url: SITE_URL+'order/load-order-history',
        type: 'POST',
        data: {offset:parseInt(oh_offset),search:search},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".oh.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".oh.load_more_btn a").text('Loading...');
            if(parseInt(oh_offset)==0){
                $('#ohlist').html("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+KITCHEN_IMAGES_URL+"loading-please-wait.gif'></div>");
            }else{
                $('#ohlist').append("<div class='loading-image' style='text-align:center;width: 100%;'><img style='width: 200px;' src='"+KITCHEN_IMAGES_URL+"loading-please-wait.gif'></div>");
            }
        },
        success: function(response){

            $('#ohlist .loading-image').remove();

            if(parseInt(oh_offset)==0){
                $("#ohlist").html(response.html);
            }else{
                $("#ohlist").append(response.html);
            }
            oh_offset = parseInt(oh_offset) + parseInt(PER_PAGE_ORDER);
            
            if(parseInt(oh_offset) >= parseInt(response.totalrows)){
                $(".oh.load_more_btn").hide();
            }else{
                $(".oh.load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".oh.load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".oh.load_more_btn a").text('Load More');
        },
    });
}