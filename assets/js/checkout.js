var searchInput = 'delivery_address';
$(document).ready(function(){
    calculate_sub_total();

    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete(document.getElementById(searchInput));
	
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        document.getElementById('deliverylatitude').value = near_place.geometry.location.lat();
        document.getElementById('deliverylongitude').value = near_place.geometry.location.lng();
        // console.log(near_place.formatted_address);
        // var lat_1 = $("#kitchen_latitude").val();
        // var long_1 = $("#kitchen_longitude").val();
        // var lat_2 = $("#deliverylatitude").val();
        // var long_2 = $("#deliverylongitude").val();
    
        getDistance(near_place.formatted_address,kitchen_address,'distance',1);
    });
});
$(document).on('keyup', '.class_cart_items .mealcount', function(){
    var id = $(this).attr("id").match(/\d+/);
    // let mealcount = $('#mealcount'+id).val();
    var cart_id = $("#cart_id"+id).val();
    editcart(cart_id,id,2);
    calculate_menu_price(id);
});
$(document).on('click', '.class_cart_items .add-meal', function(){
    var id = $(this).attr("id").match(/\d+/);
    let mealcount = $('#mealcount'+id).val();
    if(mealcount == "") {
        mealcount = 1;
        $('#mealcount'+id).val(parseInt(mealcount)) ;
        $('#btn-container'+id).css({'background-color':'#FCC647'});
        $('#mealcount'+id).css({'font-weight':'bold'});
        
    } else {
        mealcount = parseInt(mealcount)+1;
        $('#mealcount'+id).val(mealcount) ;
        $('#mealcount'+id).css({'font-weight':'bold'});
    }
    var cart_id = $("#cart_id"+id).val();
    editcart(cart_id,id,1);
    calculate_menu_price(id);
});
$(document).on('click', '.class_cart_items .remove-meal', function(){
    var id = $(this).attr("id").match(/\d+/);
    
    let mealcount = $('#mealcount'+id).val();
    
    var cart_id = $("#cart_id"+id).val();
    editcart(cart_id,id,0);
    
    if(mealcount <= 1) {
        mealcount = "0"; 
        $('#mealcount'+id).val(mealcount);
        $('#mealcount'+id).css({'font-weight':'Normal'});

        $("#id_cart_items"+id).remove();
    } else {
        mealcount = parseInt(mealcount)-1;
        $('#mealcount'+id).val(mealcount);
        $('#mealcount'+id).css({'font-weight':'bold'});
        if($('#mealcount'+id).val(mealcount)==0 )
        {
            mealcount = 'Add';
            $('#btn-container'+id).css({'background-color':'transparent'});
        }

    }
    
    calculate_menu_price(id);
});

function calculate_menu_price(menuid){
    
    var qty = $('#mealcount'+menuid).val();
    var itemprice = $('#tm_itemprice'+menuid).val();

    var total_menu_price = parseFloat(itemprice) * parseFloat(qty);
    $("#total_menu_price"+menuid).val(parseFloat(total_menu_price).toFixed(2));
    $("#txt_total_menu_price"+menuid).html("₹"+parseFloat(total_menu_price).toFixed(2));

    calculate_sub_total();   
}

function calculate_sub_total(){
    
    var total_price = 0;
    $(".total_menu_price").each(function(){
        total_price += parseFloat(this.value); 
    });
    
    var tax = $("#tax").val();
    var tax_amount = parseFloat(total_price) * parseFloat(tax) / 100;

    
    var delivery_charge = $("#delivery_charge").val();
    var coupon_ammount = $("#coupon_ammount").val();
    
    var distance = $("#distance_between_kitchen_to_customer").val(); 
    var delivery_charge_per_km = $("#delivery_charge_per_km").val(); 

    delivery_charge = (distance!="")?parseFloat(delivery_charge_per_km) * parseFloat(distance):"0";
    var sub_total = parseFloat(total_price) + parseFloat(tax_amount) + parseFloat(delivery_charge) - parseFloat(coupon_ammount);
    
    
    
    $("#delivery_charge").val(parseFloat(delivery_charge).toFixed(2));
    $("#txt_delivery_charge").html("₹"+parseFloat(delivery_charge).toFixed(2));

    $("#tax_amount").val(parseFloat(tax_amount).toFixed(2));
    $("#txt_tax_amount").html("₹"+parseFloat(tax_amount).toFixed(2));
    $("#sub_total").val(parseFloat(sub_total).toFixed(2));
    $("#txt_sub_total").html("₹"+parseFloat(sub_total).toFixed(2));


}

function check_offer_code(kitchen_id){
    var offercode = $("#offercode").val();   

    $("#offercode").css("border-bottom","1px solid #E8E9F2");
    
    if(offercode==""){
        toastr.error("Please enter offer code !");
        $("#offercode").css("border-bottom","1px solid #ff0000").focus();
    }else{
        var total_price = 0;
        $(".total_menu_price").each(function(){
            total_price += parseFloat(this.value); 
        });
        
        $.ajax({
            url: SITE_URL+'checkout/check-offer-code',
            type: 'POST',
            data: {kitchen_id:kitchen_id, offercode:offercode, orderamount:total_price},
            dataType: 'json',
            // async: false,
            success: function(response){
                // var obj = JSON.parse(response);
                
                if(response['type'] == 1){
                    toastr.success(response['msg']);

                    var discount = response['discount'];
                    $("#coupon_ammount").val(parseFloat(discount).toFixed(2));
                    $("#txt_coupon_ammount").html("-₹"+parseFloat(discount).toFixed(2));

                    calculate_sub_total();

                }else if(response['type'] == 0){
                    toastr.error(response['msg']);
                    $("#offercode").css("border-bottom","1px solid #ff0000").focus();
                }
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
        });
    }
}
function show_ordering_for_popup(){

    $("#ordering-for-modal").modal("show");

    var name = $("#orderingforname").val();
    var mobileno = $("#orderingformobileno").val();
    
    $("#modal_ord_for_name").val(name);
    $("#modal_ord_for_mobile").val(mobileno);
    
}
function check_order_for_detail(){
    var name = $("#modal_ord_for_name").val();
    var mobileno = $("#modal_ord_for_mobile").val();
    var isvalid = 1;

    if(name==""){
        $("#modal_ord_for_name_error").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please enter name !');
        isvalid = 0;
    }else if(name.length < 2){
        $("#modal_ord_for_name_error").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Name require min. 2 characters !');
        isvalid = 0;
    }else{
        $("#modal_ord_for_name_error").html("");
    }
    if(mobileno==""){
        $("#modal_ord_for_mobile_error").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please enter mobile no. !');
        isvalid = 0;
    }else if(mobileno.length != 10){
        $("#modal_ord_for_mobile_error").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Mobile no. require 10 digits !');
        isvalid = 0;
    }else{
        $("#modal_ord_for_mobile_error").html("");
    }

    if(isvalid==1){
        $("#orderingforname").val(name);
        $("#orderingformobileno").val(mobileno);

        $("#txt_ord_for").html(name+", "+mobileno);

        $("#ordering-for-modal").modal("hide");
    }
}

function checkout(){
    var wallet = $("input[name=wallet_payment_method]").is(":checked"); 
    var payment_method = $("input[name=payment_method]").is(":checked"); 
    var delivery_address = $("#delivery_address").val(); 
    var orderingforname = $("#orderingforname").val(); 
    var orderingformobileno = $("#orderingformobileno").val(); 
    var noofcartitems = $(".noofcartitems").length; 
    var orderamount = $("#sub_total").val(); 
    var wallet_balance_amount = $("#wallet_balance_amount").val(); 

    var is_valid = 1;
    var payment_amount = 0;

    if(payment_method == false && wallet == false){
        toastr.error("Please select payment method !");
        is_valid = 0;
    }else{
        if(wallet == true && payment_method == false && parseFloat(wallet_balance_amount) < parseFloat(orderamount)){
            toastr.error("Insufficient balance in your wallet. Add money in your wallet or select payment method !");
            is_valid = 0;
        }
        payment_amount = parseFloat(orderamount);

        if(wallet == true && payment_method == true && parseFloat(wallet_balance_amount) < parseFloat(orderamount)){
            if(parseFloat(wallet_balance_amount) > 0){
                payment_amount = parseFloat(orderamount) - parseFloat(wallet_balance_amount);
            }
        }
        /* if($("input[name=payment_method]:checked").val() == "by_card"){

            if(cardFormValidate() == false){
                toastr.error("Please enter correct card details !");
                is_valid = 0;
            }

        } */
    }
    if(delivery_address == ""){
        toastr.error("Please enter location !");
        is_valid = 0;
    }
    if(orderingforname == "" || orderingformobileno == ""){
        toastr.error("Please enter ordering for name & mobile no. !");
        is_valid = 0;
    }
    if(noofcartitems <= 0){
        toastr.error("Add atleast one item in cart !");
        is_valid = 0;
    }


    if(is_valid){
        /* if(payment_method == true && parseFloat(payment_amount) > 0){
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "amount").val(parseFloat(payment_amount).toFixed(2)));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "firstname").val($("#customer_name").val()));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "lastname").val($("#customer_name").val()));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "email").val($("#customer_email").val()));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "phone").val($("#customer_mobileno").val()));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "address1").val(delivery_address));
            
            $('#payment_form').submit();
        } */
        var formdata = new FormData($('#checkout_form')[0]);
        $.ajax({
            url: SITE_URL+'checkout/place-order',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            // async: false,
            beforeSend: function(){
                $('#btn-checkout').css('opacity','0.3').prop("disabled",true);
            },
            success: function(response){
                // var obj = JSON.parse(response);
                
                if(response['type'] == 1){
                    // toastr.success(response['msg']);
                    
                    if(payment_method == true && parseFloat(payment_amount) > 0){

                        $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "amount").val(parseFloat(payment_amount).toFixed(2)));
                        $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "firstname").val($("#customer_name").val()));
                        $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "lastname").val($("#customer_name").val()));
                        $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "email").val($("#customer_email").val()));
                        $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "phone").val($("#customer_mobileno").val()));
                        $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "address1").val(delivery_address));
                        $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "order_id").val(response['order_id']));
                        
                        $('#payment_form').submit();
                    }else{
                        if(wallet == true && payment_method == false){
                            toastr.success(response['msg']);

                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                    $('#btn-checkout').css('opacity','1').prop("disabled",false);
                    
                }else if(response['type'] == 0){
                    toastr.error(response['msg']);
                }
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

}
/* function cardFormValidate(){
    var cardValid = 0;

    //card number validation
    $('#card_number').validateCreditCard(function(result){
        if(result.valid){
            cardValid = 1;
        }else{
            cardValid = 0;
        }
    });
      
    //card details validation
    var cardName = $("#cardholder_name").val();
    var validthru = $("#validthru").val().toString().split("/");
    var expMonth = validthru[0];
    var expYear = $("#validthru").val() != "" ? (validthru[1].length==2)?"20"+validthru[1]:validthru[1] : "";
    var cvv = $("#cvv").val();
    var regName = /^[a-z ,.'-]+$/i;
    var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
    var regYear = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
    var regCVV = /^[0-9]{3,3}$/;
    if (cardValid == 0) {
        $("#card_number").addClass('required');
        $("#card_number").focus();
        return false;
    }else if (!regMonth.test(expMonth)) {
        $("#card_number").removeClass('required');
        $("#validthru").addClass('required');
        $("#validthru").focus();
        return false;
    }else if (!regYear.test(expYear)) {
        $("#card_number").removeClass('required');
        $("#validthru").removeClass('required');
        $("#validthru").addClass('required');
        $("#validthru").focus();
        return false;
    }else if (!regCVV.test(cvv)) {
        $("#card_number").removeClass('required');
        $("#validthru").removeClass('required');
        $("#validthru").removeClass('required');
        $("#cvv").addClass('required');
        $("#cvv").focus();
        return false;
    }else if (!regName.test(cardName)) {
        $("#card_number").removeClass('required');
        $("#validthru").removeClass('required');
        $("#validthru").removeClass('required');
        $("#cvv").removeClass('required');
        $("#cardholder_name").addClass('required');
        $("#cardholder_name").focus();
        return false;
    }else{
        $("#card_number").removeClass('required');
        $("#validthru").removeClass('required');
        $("#validthru").removeClass('required');
        $("#cvv").removeClass('required');
        $("#cardholder_name").removeClass('required');
        return true;
    }
} */

function checkout2(){
    var wallet = $("input[name=wallet_payment_method]").is(":checked"); 
    var payment_method = $("input[name=payment_method]").is(":checked"); 
    var delivery_address = $("#delivery_address").val(); 
    var orderingforname = $("#orderingforname").val(); 
    var orderingformobileno = $("#orderingformobileno").val(); 
    var noofcartitems = $(".noofcartitems").length; 
    var orderamount = $("#sub_total").val(); 
    var wallet_balance_amount = $("#wallet_balance_amount").val(); 

    var is_valid = 1;
    var payment_amount = 0;

    if(payment_method == false && wallet == false){
        toastr.error("Please select payment method !");
        is_valid = 0;
    }else{
        if(wallet == true && payment_method == false && parseFloat(wallet_balance_amount) < parseFloat(orderamount)){
            toastr.error("Insufficient balance in your wallet. Add money in your wallet or select payment method !");
            is_valid = 0;
        }

        payment_amount = parseFloat(orderamount);
        if(wallet == true && payment_method == true && parseFloat(wallet_balance_amount) < parseFloat(orderamount)){
            if(parseFloat(wallet_balance_amount) > 0){
                payment_amount = parseFloat(orderamount) - parseFloat(wallet_balance_amount);
            }
        }
        if($("input[name=payment_method]:checked").val() == "by_card"){

            if(cardFormValidate() == false){
                // toastr.error("Please enter correct card details !");
                // is_valid = 0;
            }

        }
    }
    if(delivery_address == ""){
        toastr.error("Please enter location !");
        is_valid = 0;
    }
    if(orderingforname == "" || orderingformobileno == ""){
        toastr.error("Please enter ordering for name & mobile no. !");
        is_valid = 0;
    }
    if(noofcartitems <= 0){
        toastr.error("Add atleast one item in cart !");
        is_valid = 0;
    }


    if(is_valid){
        
        if(payment_method == true && parseFloat(payment_amount) > 0){

            var method = "CC";
            if($("input[name=payment_method]:checked").val() == "by_netbanking"){
                method = "NB";
            }else if($("input[name=payment_method]:checked").val() == "by_upi"){
                method = "UPI";
            }
            
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "bankcode").val(method));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "amount").val(parseFloat(10).toFixed(2)));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "firstname").val($("#customer_name").val()));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "lastname").val($("#customer_name").val()));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "email").val($("#customer_email").val()));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "phone").val($("#customer_mobileno").val()));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "address1").val(delivery_address));
            $("#payment_form").append($("<input>").attr("type", "hidden").attr("name", "order_id").val(13));
            
            $('#payment_form').submit();

        }
        $('#btn-checkout').css('opacity','1').prop("disabled",false);
    }

}
