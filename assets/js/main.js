jQuery(document).ready(function() {
    toastr.options = {
        // "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        // "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
      
});

function checkEmail(email){  
    var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (pattern.test(email)) {  
      return true;
    }else{
        return false;  
    }  
} 
function isNumeric(event) {
    event = (event) ? event : window.event;
    var charCode = (event.which) ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
}


$(document).ready(function() {
    $("#MenuToggleButton").click(function() {
        $("body").toggleClass("collapseMenu");
    })
});
jQuery(document).ready(function() {
    if (jQuery(window).width() < 991) {
        $("body").toggleClass("collapseMenu");
    }
});

function addtocart(kitchen_id,id,cal_type){
    
    var qty = $('#mealcount'+id).val();
    var itemname = $('#tm_itemname'+id).val();
    var itemprice = $('#tm_itemprice'+id).val();

    $.ajax({
        url: SITE_URL+'kitchen-detail/addtocart',
        type: 'POST',
        data: {'kitchen_id':kitchen_id, 'menuid':parseInt(id),'itemname':itemname,'itemprice':itemprice,'quantity':qty,cal_type:cal_type},
        dataType: 'json',
        // async: false,
        success: function(response){
            if(response.cartcount==0){
                $("#cart_count_header").removeClass("base-count");
                $("#cart_count_header").html('');
            }else{
                $("#cart_count_header").html(response.cartcount);
                $("#cart_count_header").addClass("base-count");
            }
            if(response.type == 1){

            }else if(response.type == 2){
                swal({
                    title: "Items already in cart",
                    text: "Your cart contains items from other kitchen. Would you like to reset your cart for adding items from this kitchen?",
                    type: "warning",
                    showCancelButton: true,   
                    confirmButtonColor: "#FFA451",   
                    cancelButtonText: "No",   
                    confirmButtonText: "Yes, Start a Fresh",   
                    closeOnConfirm: false }, 
                    function(isConfirm){   
                    if (isConfirm) {   
                        $.ajax({
                            url: SITE_URL + "kitchen-detail/remove-cart-items",
                            // dataType: "json",
                            type: "POST",
                            success: function (data) {
                                if(data==1){
                                    swal.close();
                                    addtocart(kitchen_id,id,cal_type);
                                }
                            }
                        });
                    }else{

                        // toastr.success('Meal successfully added to cart.');

                        $('#mealcount'+id).val("Add");
                        $('#removemeal'+id).hide();
                        $('#mealcount'+id).css({'font-weight':'Normal'});
    
                        $('#btn-container'+id).css({'background-color':'#FFFAEE'});
                    }
                });
                
            }else if(response.type == 3){
                swal({
                    title: "Already added package in cart",
                    text: "Your cart contains items from package. Would you like to reset your cart for adding trial meal items in cart?",
                    type: "warning",
                    showCancelButton: true,   
                    confirmButtonColor: "#FFA451",   
                    cancelButtonText: "No",   
                    confirmButtonText: "Yes, Start a Fresh",   
                    closeOnConfirm: false }, 
                    function(isConfirm){   
                    if (isConfirm) {   
                        $.ajax({
                            url: SITE_URL + "kitchen-detail/remove-cart-items",
                            // dataType: "json",
                            type: "POST",
                            success: function (data) {
                                if(data==1){
                                    swal.close();
                                    addtocart(kitchen_id,id,cal_type);
                                }
                            }
                        });
                    }else{

                        // toastr.success('Meal successfully added to cart.');

                        $('#mealcount'+id).val("Add");
                        $('#removemeal'+id).hide();
                        $('#mealcount'+id).css({'font-weight':'Normal'});
    
                        $('#btn-container'+id).css({'background-color':'#FFFAEE'});
                    }
                });
            }
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}

function editcart(cart_id,id,cal_type){
    var qty = $('#mealcount'+id).val();

    $.ajax({
        url: SITE_URL+'kitchen-detail/editcart',
        type: 'POST',
        data: {'cart_id':cart_id, 'quantity':qty, cal_type:cal_type},
        dataType: 'json',
        // async: false,
        success: function(response){
            if(response.cartcount==0){
                $("#cart_count_header").removeClass("base-count");
                $("#cart_count_header").html('');

                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }else{
                $("#cart_count_header").html(response.cartcount);
                $("#cart_count_header").addClass("base-count");
            }

        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}
/* function getDistance(latitude_1,longitude_1,latitude_2,longitude_2){

    if(latitude_1 !="" && longitude_1 !="" && latitude_2 !="" && longitude_2 !=""){
        $.ajax({
            url: SITE_URL+'checkout/getDistance',
            type: 'POST',
            data: {'latitude_1':latitude_1, 'longitude_1':longitude_1,'latitude_2':latitude_2,'longitude_2':longitude_2},
            dataType: 'json',
            // async: false,
            success: function(response){
                $("#distance_between_kitchen_to_customer").val(parseFloat(response));
                calculate_sub_total();
                // console.log(latitude_1+","+longitude_1+" "+latitude_2+","+longitude_2);
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
        });
    }
} */

function getDistance(origin,destination,type,return_with_km){

    if(origin !="" && destination !="" && type !=""){
        $.ajax({
            url: SITE_URL+'checkout/getDistance',
            type: 'POST',
            data: {'origin':origin, 'destination':destination,'type':type,return_with_km:return_with_km},
            dataType: 'json',
            // async: false,
            success: function(response){
                $("#distance_between_kitchen_to_customer").val(parseFloat(response));
                calculate_sub_total();
                // console.log(latitude_1+","+longitude_1+" "+latitude_2+","+longitude_2);
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
        });
    }
}