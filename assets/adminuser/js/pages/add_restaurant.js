$(document).ready(function() {
  
});
function validfile(obj){
    var val = obj.val();
    var id = obj.attr('id').match(/\d+/);
    var filename = obj.val().replace(/C:\\fakepath\\/i, '');
    var filesize = obj[0].files[0].size;
    
    switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
      case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': 
        
        isvalidfile = 1;
        $("#textimage").val(filename);
        $("#image_div").removeClass("has-error is-focused");
        $("#isvalidimage").val(1);
        break;
      default:
        
        $("#textimage").val("");
        $("#image_div").addClass("has-error is-focused");
        $("#isvalidimage").val(0);
        new PNotify({title: 'Accept only image file !',styling: 'fontawesome',delay: '3000',type: 'error'});
        break;
    }
}
function resetdata(){

    $("#firstname_div").removeClass("has-error is-focused");
    $("#lastname_div").removeClass("has-error is-focused");
    $("#restaurantname_div").removeClass("has-error is-focused");
    $("#email_div").removeClass("has-error is-focused");
    $("#phoneno_div").removeClass("has-error is-focused");
    $("#restaurantcity_div").removeClass("has-error is-focused");
    $("#restaurantprovince_div").removeClass("has-error is-focused");
    $("#restaurantpostalcode_div").removeClass("has-error is-focused");
    $("#restaurantcountry_div").removeClass("has-error is-focused");
  
    if(ACTION==0){
        $('#firstname,#lastname,#restaurantname,#email,#phoneno,#restaurantcity,#restaurantprovince,#restaurantpostalcode,#restaurantcountry,$textimage').val('');
    }
    $('html, body').animate({scrollTop:0},'slow');
}
function checkvalidation(){
  
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var restaurantname = $("#restaurantname").val().trim();
    var email = $("#email").val().trim();
    var phoneno = $("#phoneno").val().trim();
    var restaurantcity = $("#restaurantcity").val().trim();
    var restaurantprovince = $("#restaurantprovince").val().trim();
    var restaurantpostalcode = $("#restaurantpostalcode").val().trim();
    var restaurantcountry = $("#restaurantcountry").val().trim();
  
    var isvalidfirstname = isvalidlastname = isvalidrestaurantname = isvalidemail = isvalidphoneno = isvalidrestaurantcity = isvalidrestaurantprovince = isvalidrestaurantpostalcode = isvalidrestaurantcountry = 0;
    PNotify.removeAll();
    if(firstname == ''){
        $("#firstname_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter first name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
        if(firstname.length<2){
            $("#firstname_div").addClass("has-error is-focused");
            new PNotify({title: 'First name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
            $("#firstname_div").removeClass("has-error is-focused");
            isvalidfirstname = 1;
        }
    }
    if(lastname == ''){
        $("#lastname_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter last name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
        if(lastname.length<2){
            $("#lastname_div").addClass("has-error is-focused");
            new PNotify({title: 'Last name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
            $("#lastname_div").removeClass("has-error is-focused");
            isvalidlastname = 1;
        }
    }
    if(restaurantname == ''){
        $("#restaurantname_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter restaurant name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
        if(restaurantname.length<2){
            $("#restaurantname_div").addClass("has-error is-focused");
            new PNotify({title: 'Restaurant name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
            $("#restaurantname_div").removeClass("has-error is-focused");
            isvalidrestaurantname = 1;
        }
    }
    if(email == ""){
        $("#email_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter email !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else { 
        if(!ValidateEmail(email)){
            $("#email_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter valid email address !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
            $("#email_div").removeClass("has-error is-focused");
            isvalidemail = 1;
        }
    }
    if(phoneno == ''){
        $("#phoneno_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter phone number !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
        if(phoneno.length < 10){
            $("#phoneno_div").addClass("has-error is-focused");
            new PNotify({title: 'Phone number require minimum 10 digits !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
            $("#phoneno_div").removeClass("has-error is-focused");
            isvalidphoneno = 1;
        }
    }
    if(restaurantcity == ''){
        $("#restaurantcity_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter restaurant city !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
        $("#restaurantcity_div").removeClass("has-error is-focused");
        isvalidrestaurantcity = 1;
    }
    if(restaurantprovince == ''){
        $("#restaurantprovince_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter restaurant state / province !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
        $("#restaurantprovince_div").removeClass("has-error is-focused");
        isvalidrestaurantprovince = 1;
    }
    if(restaurantpostalcode == ''){
        $("#restaurantpostalcode_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter restaurant zip / postal code !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
        $("#restaurantpostalcode_div").removeClass("has-error is-focused");
        isvalidrestaurantpostalcode = 1;
    }
    if(restaurantcountry == ''){
        $("#restaurantcountry_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter restaurant country !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
        $("#restaurantcountry_div").removeClass("has-error is-focused");
        isvalidrestaurantcountry = 1;
    }
    if(isvalidfirstname==1 && isvalidlastname==1 && isvalidrestaurantname==1 && isvalidemail==1 && isvalidphoneno==1 && isvalidrestaurantcity==1 && isvalidrestaurantprovince==1 && isvalidrestaurantpostalcode==1 && isvalidrestaurantcountry==1){
  
        var formData = new FormData($('#restaurantform')[0]);
        if(ACTION==0){

        var uurl = SITE_URL+"restaurant/restaurant-add";
        
        $.ajax({
            url: uurl,
            type: 'POST',
            data: formData,
            //async: false,
            beforeSend: function(){
            $('.mask').show();
            $('#loader').show();
            },
            success: function(response){
            if(response==1){
                new PNotify({title: 'Restaurant successfully added.',styling: 'fontawesome',delay: '3000',type: 'success'});
                resetdata();              
            }else if(response==2){
                new PNotify({title: 'Restaurant already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else if(response==3){
                new PNotify({title: 'Logo not upload !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else if(response==4){
                new PNotify({title: 'Accept only image file !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else  if(response==0){
                new PNotify({title: 'Restaurant not added !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
            complete: function(){
            $('.mask').hide();
            $('#loader').hide();
            },
            cache: false,
            contentType: false,
            processData: false
        });
        }else{
        
        var uurl = SITE_URL+"restaurant/update-restaurant";

        $.ajax({
            url: uurl,
            type: 'POST',
            data: formData,
            //async: false,
            beforeSend: function(){
            $('.mask').show();
            $('#loader').show();
            },
            success: function(response){
            if(response==1){
                new PNotify({title: 'Restaurant successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
                setTimeout(function() { window.location=SITE_URL+"restaurant"; }, 1500);
            }else if(response==2){
                new PNotify({title: 'Restaurant already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else if(response==3){
                new PNotify({title: 'Logo not upload !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else if(response==4){
                new PNotify({title: 'Accept only image file !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else  if(response==0){
                new PNotify({title: 'Restaurant not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            },
            complete: function(){
            $('.mask').hide();
            $('#loader').hide();
            },
            cache: false,
            contentType: false,
            processData: false
        });
        }
    }
}

