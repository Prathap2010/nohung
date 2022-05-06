var is_default_this_card = is_default_address = oh_offset = ao_offset = ad_offset = 0; 
var searchInput = 'address';
$(document).ready(function(){
    get_cards();
    load_active_orders();
    load_order_history();
    get_address();

    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete(document.getElementById(searchInput));
	
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        document.getElementById('address_latitude').value = near_place.geometry.location.lat();
        document.getElementById('address_longitude').value = near_place.geometry.location.lng();
    });
});
function check_image(obj, element){
    var val = obj.val();
    var id = obj.attr('id').match(/\d+/);
    var filename = obj.val().replace(/C:\\fakepath\\/i, '');
    var filesize = obj[0].files[0].size;
    
    switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': 
            
            $("#isvalid"+element).val(1);
            $("#lbl"+element).html(filename);
            $("#error_"+element).html("");

            if(element == 'profile_image'){
                if (obj[0].files && obj[0].files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#img_'+element).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(obj[0].files[0]);
                }
            }
            break;
        default:
                
            $("#isvalid"+element).val(0);
            $("#lbl"+element).html("Choose file");
            $("#error_"+element).html("Accept only image file !");
            break;
    }
}
function add_card_popup(type="open",card_id=""){
    $("#error_card_name,#error_card_number,#error_cardholder_name,#error_validthru,#error_defaultcard,#error_cardimg").html("");
    
    $("#error_card_form").html("");

    if(type != "open"){

        var card_name = $("#card_name").val();
        var card_number = $("#card_number").val();
        var cardholder_name = $("#cardholder_name").val();
        var validthru = $("#validthru").val();
        var cardimg = $("#cardimg").val();
        var lblcardimg = $("#lblcardimg").html();
        var isvalidcardimg = $("#isvalidcardimg").val();
        var isvalid = 1;
    
        if(cardimg != '' && isvalidcardimg == 0){
            $("#error_cardimg").html("Accept only image file !");
            isvalid = 0;
        }
        if(card_name == ""){
            $("#error_card_name").html("Please enter card name !");
            isvalid = 0;
        }
        if(card_number == ""){
            $("#error_card_number").html("Please enter card number !");
            isvalid = 0;
        }
        if(cardholder_name == ""){
            $("#error_cardholder_name").html("Please enter card holder name !");
            isvalid = 0;
        }
        if(validthru == ""){
            $("#error_validthru").html("Please enter valid expiry date !");
            isvalid = 0;
        }
        
        if(type == 'edit' && is_default_this_card == 1 && $("#default-payment-card").prop("checked") == false){
            $("#error_defaultcard").html("Please mark card as a default !");
            isvalid = 0;
        }
        
        if(isvalid){
            var formdata = new FormData($('#card_form')[0]);

            $.ajax({
                url: SITE_URL+'my-account/add-card',
                type: 'POST',
                data: formdata,
                dataType: 'json',
                // async: false,
                success: function(response){
                    if(type == 'add'){

                        if(response==1){
                            $("#error_card_form").html('<div class="alert alert-success"><i class="fa fa-check"></i> Card successfully added !</div>').css("color","green"); 
                            setTimeout(() => {
                                $("#addpayment").modal("hide");
                                $("#error_card_form").html("");
    
                                get_cards();
                            }, 2000);
                        }else{
                            $("#error_card_form").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Card not added !</div>').css("color","red");  
                        }
                    }else{
                        if(response==1){
                            $("#error_card_form").html('<div class="alert alert-success"><i class="fa fa-check"></i> Card successfully updated !</div>').css("color","green"); 
                            setTimeout(() => {
                                $("#addpayment").modal("hide");
                                $("#error_card_form").html("");

                                if(cardimg!="" && isvalidcardimg==1){
                                    // $("#txt_image_"+card_id).attr('src', SITE_URL+"assets/uploaded/cards/"+lblcardimg);
                                }
                                
                                $("#txt_cardnm_"+card_id).html(card_name);
                                $("#txt_cardno_"+card_id).html(card_number);
                                $("#txt_holder_name_"+card_id).html(cardholder_name);
                                $("#txt_valid_thru_"+card_id).html(validthru);
                                
                                if($("#default-payment-card").prop("checked") == true){
                                    $(".default_card_cls").html("");
                                    $("#default_card_id_"+card_id).html('Default Card for All Payments');
                                }else{
                                    if(is_default_this_card == 1){
                                        $(".default_card_cls").html("");
                                    }
                                }
                                // get_cards();
                            }, 2000);
                        }else{
                            $("#error_card_form").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Card not update !</div>').css("color","red");  
                        }
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
    }else{
        $("#card_name,#card_number,#cardholder_name,#validthru,#oldcardimg").val("");
        $("#default-payment-card").prop('checked', false);
        $("#isvalidcardimg").val("0");
        $("#lblcardimg").html("Choose file");
        $("#add_card").html("Add Card").attr("onclick","add_card_popup('add')");
    }
}

function get_cards(){
    $.ajax({
        url: SITE_URL+'my-account/get-cards',
        type: 'POST',
        data: {customer_id:customer_id},
        dataType: 'json',
        // async: false,
        success: function(response){
            // var obj = JSON.parse(response);
            var html = "";
            if(response.length > 0){
                for(var i=0; i<response.length; i++){
                    html += '<div class="order-active-content col-md-6 cardbox" style="position: relative;" id="card-div-'+response[i]['id']+'">\
                                <div class="name-bill">\
                                    <p><img id="txt_image_'+response[i]['id']+'" style="height: 50px;border-radius: 50%;margin-right: 5px;" src="'+response[i]['image']+'"><span id="txt_cardnm_'+response[i]['id']+'">'+response[i]['card_name']+'</span></p>\
                                    <p><b>Card Number : </b><span id="txt_cardno_'+response[i]['id']+'">'+(response[i]['card_number'].replace(/.(?=.{4})/g, "X"))+'</span></p>\
                                    <p><b>Card Holder Name : </b><span id="txt_holder_name_'+response[i]['id']+'">'+response[i]['holder_name']+'</span></p>\
                                    <p><b>Validthru : </b><span id="txt_valid_thru_'+response[i]['id']+'">'+response[i]['valid_thru']+'</span></p>\
                                    <span style="color:#4bb64b;" id="default_card_id_'+response[i]['id']+'" class="default_card_cls">'+(response[i]['is_default']=='y' ? "Default Card for All Payments" : "")+'</span>\
                                </div>\
                                <div class="btn-container" style="position: absolute;top: 5px;right: 10px;">\
                                    <a href="javascript:void(0)" onclick="edit_card('+response[i]['id']+')" data-toggle="modal" data-target="#addpayment"><img src="'+FRONT_IMAGES_URL+'pencil.png" alt="" class="img-fluid"></a>\
                                    <a href="javascript:void(0)" onclick="remove_card('+response[i]['id']+')" style><img src="'+FRONT_IMAGES_URL+'trash2.png" alt="" class="img-fluid"></a>\
                                </div>\
                            </div>';
                }
            }else{
                html = '<p class="heading">No Payment Method Added</p>\
                        <div class="img-container">\
                            <img src="'+FRONT_IMAGES_URL+'Group10491.png" alt="" class="img-fluid">\
                        </div>';
            }
            $("#manage_card_section").html(html);
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}
function remove_card(card_id){
    
    BootstrapDialog.confirm('Are you sure you want to remove card ?', function(result){
        if(result) {
            $.ajax({
                url: SITE_URL+'my-account/remove-card',
                type: 'POST',
                data: {card_id:card_id},
                dataType: 'json',
                // async: false,
                success: function(response){
                    $('#card-div-'+card_id).remove();
                },
                error: function(xhr) {
                //alert(xhr.responseText);
                },
            });
        }
    });
}
function edit_card(card_id){
    add_card_popup();
    $("#add_card").html("Update Card").attr("onclick","add_card_popup('edit',"+card_id+")");

    if(card_id != ""){

        $.ajax({
            url: SITE_URL+'my-account/get-card-detail',
            type: 'POST',
            data: {card_id:card_id},
            dataType: 'json',
            // async: false,
            success: function(response){
                $("#card_id").val(response.id);
                $("#card_name").val(response.card_name);
                $("#card_number").val(response.card_number);
                $("#cardholder_name").val(response.holder_name);
                $("#validthru").val(response.valid_thru);
                $("#oldcardimg").val(response.image);
                if(response.image!=""){
                    $("#lblcardimg").html(response.image);
                }else{
                    $("#lblcardimg").html("Choose file");
                }
                $("#isvalidcardimg").val((response.image!=""?1:0));
                if(response.is_default == 'y'){
                    $("#default-payment-card").prop('checked', true);
                    is_default_this_card = 1;
                }else{
                    $("#default-payment-card").prop('checked', false);
                    is_default_this_card = 0;
                }
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
        });
    }

}
function load_active_orders(){
    
    $.ajax({
        url: SITE_URL+'my-account/load-active-orders',
        type: 'POST',
        data: {offset:parseInt(ao_offset)},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".ao.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".ao.load_more_btn a").text('Loading...');
        },
        success: function(response){

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
function load_order_history(){
    
    $.ajax({
        url: SITE_URL+'my-account/load-order-history',
        type: 'POST',
        data: {offset:parseInt(oh_offset)},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".oh.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".oh.load_more_btn a").text('Loading...');
        },
        success: function(response){

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
function get_address(){
    
    $.ajax({
        url: SITE_URL+'my-account/get-address',
        type: 'POST',
        data: {offset:parseInt(ad_offset)},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".ad.load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".ad.load_more_btn a").text('Loading...');
        },
        success: function(response){

            if(parseInt(ad_offset)==0){
                $("#adlist").html(response.html);
            }else{
                $("#adlist").append(response.html);
            }
            ad_offset = parseInt(ad_offset) + parseInt(PER_PAGE_ADDRESS);
            
            if(parseInt(ad_offset) >= parseInt(response.totalrows)){
                $(".ad.load_more_btn").hide();
            }else{
                $(".ad.load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".ad.load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".ad.load_more_btn a").text('Load More');
        },
    });
}
function add_address_popup(type="open",address_id=""){
    $("#error_address,#error_defaultaddress").html("");
    $("#error_address_form").html("");

    if(type != "open"){

        var address = $("#address").val();
        var isvalid = 1;
    
        if(address == ""){
            $("#error_address").html("Please enter address !");
            isvalid = 0;
        }
        if(type == 'edit' && is_default_address == 1 && $("#default-address").prop("checked") == false){
            $("#error_defaultaddress").html("Please mark address as a default !");
            isvalid = 0;
        }
        
        if(isvalid){
            var formdata = new FormData($('#address_form')[0]);

            $.ajax({
                url: SITE_URL+'my-account/add-address',
                type: 'POST',
                data: formdata,
                dataType: 'json',
                // async: false,
                success: function(response){
                    if(type == 'add'){

                        if(response==1){
                            $("#error_address_form").html('<div class="alert alert-success"><i class="fa fa-check"></i> Address successfully added !</div>').css("color","green"); 
                            setTimeout(() => {
                                $("#addaddress").modal("hide");
                                $("#error_address_form").html("");
                                
                                ad_offset = 0; 
                                get_address();
                            }, 2000);
                        }else{
                            $("#error_address_form").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Address not added !</div>').css("color","red");  
                        }
                    }else{
                        if(response==1){
                            $("#error_address_form").html('<div class="alert alert-success"><i class="fa fa-check"></i> Address successfully updated !</div>').css("color","green"); 
                            setTimeout(() => {
                                $("#addaddress").modal("hide");
                                $("#error_card_form").html("");
    
                                $("#txt_address_"+address_id).html(address);
                                
                                if($("#default-address").prop("checked") == true){
                                    $(".default_address_cls").html("");
                                    $("#default_address_id_"+address_id).html('<i class="fa fa-long-arrow-right" aria-hidden="true"></i>&nbsp;Default Address');
                                }else{
                                    if(is_default_address == 1){
                                        $(".default_address_cls").html("");
                                    }
                                }
                                // get_cards();
                            }, 2000);
                        }else{
                            $("#error_address_form").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Address not update !</div>').css("color","red");  
                        }
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
    }else{
        $("#address").val("");
        $("#default-address").prop('checked', false);
        $("#add_address").html("Add Address").attr("onclick","add_address_popup('add')");
        $("#addaddress .modal-title").html("Add Address");
    }
}
function edit_address(address_id){
    add_address_popup();
    $("#add_address").html("Update Address").attr("onclick","add_address_popup('edit',"+address_id+")");
    $("#addaddress .modal-title").html("Edit Address");

    if(address_id != ""){

        var address = $("#txt_address_"+address_id).html();
        var lat = $("#txt_lat_"+address_id).val();
        var long = $("#txt_long_"+address_id).val();
        var is_delivery = $("#txt_is_delivery_"+address_id).val();

        $("#address_id").val(address_id);
        $("#address").val(address.trim());
        
        if(is_delivery == 'y'){
            $("#default-address").prop('checked', true);
            is_default_address = 1;
        }else{
            $("#default-address").prop('checked', false);
            is_default_address = 0;
        }
    }

}
function open_deposit_popup(){
    $("#error_deposit").html("");
    $("#error_deposit_form").html("");

    $("#amount").val("");
}
function add_deposit_amount(){
    var depositamount = $("#depositamount").val();
    var isvalid = 1;

    if(depositamount == 0){
        $("#error_depositamount").html("Please enter amount !");
        isvalid = 0;
    }
    
    if(isvalid){
        var formdata = new FormData($('#deposit_form')[0]);

        $.ajax({
            url: SITE_URL+'my-account/add-deposit-amount',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            // async: false,
            success: function(response){
                if(response.status=='success'){
                    $("#error_deposit_form").html('<div class="alert alert-success"><i class="fa fa-check"></i> Deposit successfully added to your wallet !</div>').css("color","green"); 
                    setTimeout(() => {
                        window.location.href = SITE_URL+"payment/make-deposit-payment/"+response.id;
                    }, 1000);
                }else{
                    $("#error_deposit_form").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Deposit not added !</div>').css("color","red");  
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
function update_account(){
    
    var profile_image = $("#profile_image").val();
    var validprofile_image = $("#isvalidprofile_image").val();
    var user_name = $("#user_name").val();
    var user_email = $("#user_email").val();
    
    var isvalid = 1;
    $("#error_user_form, #error_user_name, #error_user_email, #error_profile_image").html("");

    if(user_name == ""){
        $("#error_user_name").html("Please enter name !");
        isvalid = 0;
    }
    if(user_email == ""){
        $("#error_user_email").html("Please enter email !");
        isvalid = 0;
    }else if(user_email != "" && !checkEmail(user_email)){
        $("#error_user_email").html("Please enter valid email address !");
        isvalid = 0;
    }

    if(profile_image != "" && validprofile_image == 0){
        $("#error_profile_image").html("Accept only image file !");
        isvalid = 0;
    }
    
    if(isvalid){
        var formdata = new FormData($('#user_form')[0]);

        $.ajax({
            url: SITE_URL+'my-account/update-account',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            // async: false,
            success: function(response){
                if(response==1){
                    $("#error_user_form").html('<div class="alert alert-success"><i class="fa fa-check"></i> Profile successfully updated !</div>').css("color","green"); 
                    setTimeout(() => {
                        $("#editprofileModal").modal("hide");
                        window.location.reload();
                    }, 2000);
                }else if(response==2){
                    $("#error_user_email").html("Email already register !");
                }else if(response==3){
                    $("#error_profile_image").html("Profile image not uploaded !");
                }else if(response==4){
                    $("#error_profile_image").html("Invalid profile image type !");
                }else{
                    $("#error_user_form").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Profile not update !</div>').css("color","red");  
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