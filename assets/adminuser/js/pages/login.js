$(document).ready(function(){
  $("input").keypress(function(event) {
    if (event.which == 13){
      event.preventDefault();
      $("#btnloginsubmit").click();
    }
  });
  $(".eye").css("display", "none");
});

function showPassword(element){
  if($("#"+element).attr('type') == "password"){
    $("#"+element).attr('type','text');
  } else if($("#"+element).attr('type') == "text") {
    $("#"+element).attr('type','password');
  }
  $("#"+element).next("i").toggleClass("fa fa-eye-slash fa fa-eye eye");
}

$("#loginPassword").keyup(function(){
  if($(this).val()){
    $(this).next("i").css("display","block");
  } else {
    $(this).next("i").css("display","none");
  }
});

function checkLogin(){
    var email = $.trim($("#loginEmail").val());
    var password = $.trim($("#loginPassword").val());
    
    var isvalidemail=0,isvalidpassword=0;

    if(email!='' && password!=''){
        if(email!=''){
            if(ValidateEmail(email)){
                $("#email_div").removeClass("has-error is-focused");
                isvalidemail=1;
            }else{
                if(!isNaN(email)){
                    $("#email_div").removeClass("has-error is-focused");
                    isvalidemail=1;
                }else{
                    $("#email_div").addClass("has-error is-focused");
                    new PNotify({title: 'Please enter valid Email ID !',styling: 'fontawesome',delay: '3000',type: 'error'});
                    isvalidemail=0;
                }
            }
        }else{
            $("#email_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter Email ID !',styling: 'fontawesome',delay: '3000',type: 'error'});
            isvalidemail=0;
        }

        if(password!=''){
            isvalidpassword=1;
        }else{
            $("#password_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter password !',styling: 'fontawesome',delay: '3000',type: 'error'});
            isvalidpassword=0;
        }
        if(isvalidemail==1 && isvalidpassword==1){
            var datastr = 'email='+email+'&password='+password;
            var baseurl = SITE_URL+'login/check_login';
            $.ajax({
                url: baseurl,
                type: 'POST',
                data: datastr,
                datatype:'json',
                beforeSend: function(){
                  $('.mask').show();
                  $('#loader').show();
                },
                success: function(data){
                    var data = JSON.parse(data);
                    
                    if(data['error'] == 1){
                       window.location.href = SITE_URL+"dashboard";
                    }else{
                        new PNotify({title: 'Invalid Email ID Or Password !',styling: 'fontawesome',delay: '3000',type: 'error'});
                    }
                },
                complete: function(){
                  $('.mask').hide();
                  $('#loader').hide();
                },
            });
        }
    }else{
        $("#email_div").addClass("has-error is-focused");
        $("#password_div").addClass("has-error is-focused");
        new PNotify({title: 'Enter Email ID Or Password !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }
    
}