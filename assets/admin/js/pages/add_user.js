$(document).ready(function() {
  
  /* if($('#oldprofileimage').val()!=''){
    var $imageupload = $('.imageupload');
    $imageupload.imageupload({
      url: SITE_URL,
      type: '1',
      allowedFormats: [ 'jpg', 'jpeg', 'png','ico']
    });
  }else{
    var $imageupload = $('.imageupload');
    $imageupload.imageupload({
      url: SITE_URL,
      type: '0',
      allowedFormats: [ 'jpg', 'jpeg', 'png','ico']
    });
  }

  $('#remove').click(function(){
    $('#removeoldImage').val('1');
  }); */
  $('#state').on('change', function (e) {
    getcity(this.value);
  });
  if(ACTION==1){
    getcity($("#state").val());
  }
  $('#expirydate').datepicker({
    todayHighlight: true,
    format: 'dd/mm/yyyy',
    autoclose: true,
    todayBtn:"linked"
  });
});

function validfile(obj){
  var val = obj.val();
  // var id = obj.attr('id').match(/\d+/);
  var id = obj.attr('id');
  var filename = obj.val().replace(/C:\\fakepath\\/i, '');
  var filesize = obj[0].files[0].size;
  
  switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
    case 'pdf': case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': 
      
      isvalidfile = 1;
      $("#text"+id).val(filename);
      $("#"+id+"_div").removeClass("has-error is-focused");
      $("#isvalid"+id).val(1);
      break;
    default:
      
      $("#text"+id).val("");
      $("#"+id+"_div").addClass("has-error is-focused");
      $("#isvalid"+id).val(0);
      new PNotify({title: 'Accept only image or pdf file !',styling: 'fontawesome',delay: '3000',type: 'error'});
      break;
  }
}
function validimage(obj){
  var val = obj.val();
  // var id = obj.attr('id').match(/\d+/);
  var id = obj.attr('id');
  var filename = obj.val().replace(/C:\\fakepath\\/i, '');
  var filesize = obj[0].files[0].size;
  
  switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
    case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': 
      
      isvalidfile = 1;
      $("#text"+id).val(filename);
      $("#"+id+"_div").removeClass("has-error is-focused");
      $("#isvalid"+id).val(1);
      break;
    default:
      
      $("#text"+id).val("");
      $("#"+id+"_div").addClass("has-error is-focused");
      $("#isvalid"+id).val(0);
      new PNotify({title: 'Accept only image file !',styling: 'fontawesome',delay: '3000',type: 'error'});
      break;
  }
}
function getcity(provinceid){
  
  $('#city')
    .find('option')
    .remove()
    .end()
    .append('<option value="">Select City</option>')
    .val('0')
  ;
  if(provinceid!=""){
    
    $.ajax({
      url: SITE_URL+"city/getCityData",
      type: 'POST',
      data: {provinceid:provinceid},
      dataType: 'json',
      async: false,
      success: function(response){

        for(var i = 0; i < response.length; i++) {
          $('#city').append($('<option>', { 
            value: response[i]['id'],
            text : response[i]['name']
          }));
        }
        if(cityid!=0){
          $('#city').val(cityid);
        }
      },
      error: function(xhr) {
        //alert(xhr.responseText);
      },
    });
  }
  $('#city').selectpicker('refresh');
}
function resetdata(){

  $("#kitchenname_div").removeClass("has-error is-focused");
  $("#email_div").removeClass("has-error is-focused");
	$("#address_div").removeClass("has-error is-focused");
  $("#state_div").removeClass("has-error is-focused");
  $("#city_div").removeClass("has-error is-focused");
  $("#profile_image_div").removeClass("has-error is-focused");

  if(ACTION==1){
  }else{
    
    $('#kitchenname,#email,#address').val('');
    $('#state,#city').val('0');
    
    $('#yes').prop("checked", true);
    $('.selectpicker').selectpicker('refresh');
  }
  $('html, body').animate({scrollTop:0},'slow');
}
function checkvalidation(){
  
  var kitchenname = $("#kitchenname").val().trim();
  var email = $("#email").val().trim();
  var address = $("#address").val().trim();
  var state = $("#state").val();
  var city = $("#city").val();

  var pincode = $("#pincode").val();
  var contactname = $("#contactname").val();
  var role = $("#role").val();
  var mobilenumber = $("#mobilenumber").val();
  var kitchencontactnumber = $("#kitchencontactnumber").val();
  
  var menufile = $("#menufile").val();
  var documentfile = $("#documentfile").val();
  var profile_image = $("#profile_image").val();
  var isvalidprofile_image = $("#isvalidprofile_image").val();
  var description = $("#description").val();

  var isvalid = 1;

  PNotify.removeAll();
  
  if(kitchenname == ''){
    $("#kitchenname_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter kitchen name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else {
    if(kitchenname.length<2){
      $("#kitchenname_div").addClass("has-error is-focused");
      new PNotify({title: 'Kitchen name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#kitchenname_div").removeClass("has-error is-focused");
    }
  }
  if(email == ''){
    $("#email_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter email !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else {
    if(!ValidateEmail(email)){
      $("#email_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter valid email address !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#email_div").removeClass("has-error is-focused");
    }
  }
  if(address == ''){
    $("#address_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter address !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else {
    if(address.length<2){
      $("#address_div").addClass("has-error is-focused");
      new PNotify({title: 'Address require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#address_div").removeClass("has-error is-focused");
    }
  }
  if(state == 0){
    $("#state_div").addClass("has-error is-focused");
    new PNotify({title: 'Please select state !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#state_div").removeClass("has-error is-focused");
  }
  if(city == 0){
    $("#city_div").addClass("has-error is-focused");
    new PNotify({title: 'Please select city !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#city_div").removeClass("has-error is-focused");
  }
  if(pincode == ''){
    $("#pincode_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter pincode !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#pincode_div").removeClass("has-error is-focused");
  }
  if(contactname == ''){
    $("#contactname_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter contact persons name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#contactname_div").removeClass("has-error is-focused");
  }
  if(role == ''){
    $("#role_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter contact persons role !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#role_div").removeClass("has-error is-focused");
  }
  if(mobilenumber == ''){
    $("#mobilenumber_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter mobile number !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#mobilenumber_div").removeClass("has-error is-focused");
  }
  if(kitchencontactnumber == ''){
    $("#kitchencontactnumber_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter kitchens contact number !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#kitchencontactnumber_div").removeClass("has-error is-focused");
  }
  if(menufile == '' && $("#isvalidmenufile").val()==0){
    $("#menufile_div").addClass("has-error is-focused");
    new PNotify({title: 'Please upload menu !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else if(menufile != '' && $("#isvalidmenufile").val()==0){
    $("#menufile_div").addClass("has-error is-focused");
    new PNotify({title: 'Accept only image or pdf file in menu !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#menufile_div").removeClass("has-error is-focused");
  }
  if(documentfile == '' && $("#isvaliddocumentfile").val()==0){
    $("#documentfile_div").addClass("has-error is-focused");
    new PNotify({title: 'Please upload document !',styling: 'fontawesome',delay: '3000',type: 'error'});  
    isvalid = 0;
  }else if(documentfile != '' && $("#isvaliddocumentfile").val()==0){
    $("#documentfile_div").addClass("has-error is-focused");
    new PNotify({title: 'Accept only image or pdf file in document !',styling: 'fontawesome',delay: '3000',type: 'error'});    
    isvalid = 0;
  }else{
    $("#documentfile_div").removeClass("has-error is-focused");
  }
  if(profile_image != '' && $("#isvalidprofile_image").val()==0){
    $("#profile_image_div").addClass("has-error is-focused");
    new PNotify({title: 'Profile image accept only image file !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#profile_image_div").removeClass("has-error is-focused");
  }
  if(description == ''){
    $("#description_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter description !',styling: 'fontawesome',delay: '3000',type: 'error'});
    isvalid = 0;
  }else{
    $("#description_div").removeClass("has-error is-focused");
  }
  if(isvalid == 1){
  
    var formData = new FormData($('#userform')[0]);
  
    var uurl = SITE_URL+"user/update-user";

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
          new PNotify({title: 'Kitchen successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
          setTimeout(function() { window.location=SITE_URL+"user"; }, 1500);
        }else if(response==2){
          new PNotify({title: 'Email already register !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else  if(response==0){
          new PNotify({title: 'Kitchen not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
          new PNotify({title: response,styling: 'fontawesome',delay: '3000',type: 'error'});
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

