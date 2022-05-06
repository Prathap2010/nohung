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
function resetdata(){
  
    $("#foodiename_div").removeClass("has-error is-focused");
    $("#email_div").removeClass("has-error is-focused");
    $("#email_div").removeClass("has-error is-focused");
    $("#profile_image_div").removeClass("has-error is-focused");

    if(ACTION==1){
    }else{
      
      $('#foodiename,#email,#address,#password').val('');
      
      $('#yes').prop("checked", true);
    }
    $('html, body').animate({scrollTop:0},'slow');
}
  function checkvalidation(){
    
    var foodiename = $("#foodiename").val().trim();
    var email = $("#email").val().trim();
    var mobilenumber = $("#mobilenumber").val();
    var password = $("#password").val();
    var confirmpassword = $("#confirmpassword").val();
    var profile_image = $("#profile_image").val();
    var isvalidprofile_image = $("#isvalidprofile_image").val();

    var isvalid = 1;
    PNotify.removeAll();
    
    if(foodiename == ''){
      $("#foodiename_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter foodie name !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else {
      if(foodiename.length<2){
        $("#foodiename_div").addClass("has-error is-focused");
        new PNotify({title: 'Foodie name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalid = 0;
      }else{
        $("#foodiename_div").removeClass("has-error is-focused");
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
   
    if(mobilenumber == ''){
      $("#mobilenumber_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter mobile number !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#mobilenumber_div").removeClass("has-error is-focused");
    }
    if(password == ''){
      $("#password_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter password !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else if(password.length < 6){
      $("#password_div").addClass("has-error is-focused");
      new PNotify({title: 'Password require minimum 6 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#password_div").removeClass("has-error is-focused");
    }
    if(confirmpassword == ''){
      $("#confirmpassword_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter confirm password !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else if(confirmpassword != password){
      $("#confirmpassword_div").addClass("has-error is-focused");
      new PNotify({title: 'Conform password does not match with password !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#confirmpassword_div").removeClass("has-error is-focused");
    }
    if(profile_image != '' && $("#isvalidprofile_image").val()==0){
      $("#profile_image_div").addClass("has-error is-focused");
      new PNotify({title: 'Profile image accept only image file !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#profile_image_div").removeClass("has-error is-focused");
    }

    if(isvalid==1){
    
        var formData = new FormData($('#foodieform')[0]);
      
        
        var uurl = SITE_URL+"foodie/update-foodie";

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
                new PNotify({title: 'Foodie successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
                setTimeout(function() { window.location=SITE_URL+"foodie"; }, 1500);
            }else if(response==2){
                new PNotify({title: 'Foodie email already register !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else if(response==3){
                new PNotify({title: 'Foodie mobile number already register !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else  if(response==0){
                new PNotify({title: 'Foodie not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
  
  