<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <?php $headerData = $this->foodies_headerlib->data(); ?>
    <head>
        <title><?php echo $title." - ".SITE_NAME;?></title>
        <meta charset="UTF-8">
        <?php echo $headerData['meta_tags']; ?>
        <?php echo $headerData['favicon']; ?>
        <?php echo $headerData['stylesheets']; ?>
        <?php echo $headerData['plugins']; ?>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <?php echo $headerData['top_javascripts']; ?>
        <script>
            var SITE_URL = '<?php echo FRONT_URL ?>';
        </script>
        <style>
            .manage-error .form-control,.manage-error .bootstrap-select button{
                border: 1px solid #fe0d0d !important;
            }
        </style>
    </head>
    <body>
        <div class= "backcolor">
        <div class="loginPopup">
            <div class="PopupClosedButton">
                <?php if(empty($this->session->userdata('redirect_url'))) {
                    $reditect_url = FRONT_URL;
                }else{ 
                    $reditect_url = $this->session->userdata('redirect_url');
                } ?>   
                <button onclick="window.location.href=$(this).attr('data-href')" data-href="<?=$reditect_url?>"><svg xmlns="http://www.w3.org/2000/svg" width="39.773" height="39.773" viewBox="0 0 39.773 39.773"><defs><style>.a{fill:#fff;}</style></defs><g transform="translate(0 19.192) rotate(-43)"><path class="a" d="M12.311,28.141V15.83H0V12.312H12.311V0h3.52V12.312H28.141V15.83H15.83V28.141Z"/></g></svg></button>
            </div>
            
            <div class="LoginContentWrap" id="step1">
                <div class="LoginLogo">
                    <img src="<?= FRONT_IMAGES_URL ?>logo.svg" alt="logo">
                </div>
                <!--<div class="IfUserNotRegister backScreen" style="margin-top: 20px;margin-bottom: -10px; margin-left: 41px;">-->
                <!--    <a href="javascript:void(0)" id="prevstep"><img src="<?= FRONT_IMAGES_URL ?>arrow.svg" alt="arrow"> <!--<span>Back</span></a>-->
                <!--</div> -->
                <div class="FormHeadingSection">
                    <h2>LOGIN</h2>
                </div>
                <div class="IfUserNotRegister">
                        <p>New to NOHUNG ? <a href="<?=FRONT_URL?>register1">signup</a></p>
                    </div>
                <form action="#" id="loginform" class="form-horizontal">
                    <h4>Welcome back,</h4>
                    <div id="login_form"></div>
                    <div class="socialMediaIcon">
                        <ul>
                            <li>
                                <a href="<?=$GoogleLoginURL?>"><img src="<?= FRONT_IMAGES_URL ?>googleIcon.svg" alt=""></a>
                            </li>
                            <li>
                                <a href="<?=$FacebookAuthURL?>"><img src="<?= FRONT_IMAGES_URL ?>facebook_icon.png" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="LoginContentWrap" id="step2" style="display: none;">
                <div class="LoginLogo">
                    <img src="<?= FRONT_IMAGES_URL ?>logo.svg" alt="logo">
                </div>
                <div class="FormHeadingSection">
                    <h2>LOGIN</h2>
                     <!--<div class="IfUserNotRegister backScreen">-->
                        <!--<a href="<?=FRONT_URL.'login'?>"><img src="<?= FRONT_IMAGES_URL ?>arrow-left.svg" alt="arrow-left"> <span>Back</span></a>-->
                    <!--</div>-->
                </div>
                <form action="#" id="otpform" class="form-horizontal">
                    <input type="hidden" id="userid" name="userid" value="">
                    <div class="form-group OPTSectionBox">
                        <input id="codeBox1" class="otptext" type="text" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)">
                        <input id="codeBox2" class="otptext" type="text" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)">
                        <input id="codeBox3" class="otptext" type="text" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)">
                        <input id="codeBox4" class="otptext" type="text" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)">
                        <input type="hidden" maxlength="4" id="otp" name="otp">
                    </div>
                    <div class="OTPreSendButton">
                        <a href="<?=FRONT_URL.'login'?>"><img src="<?= FRONT_IMAGES_URL ?>arrow-left.svg" alt="arrow-left"> <span>Back</span></a>
                        <a href="javascript:void(0)" onclick="resendotp()">Resend OTP</a>
                    </div>
                    <!--<div class="IfUserNotRegister backScreen">-->
                    <!--    <a href="<?=FRONT_URL.'login'?>"><img src="<?= FRONT_IMAGES_URL ?>arrow.svg" alt="arrow"> <span>Back</span></a>-->
                    <!--</div>-->
                </form>
            </div>
        </div>
        
        <?php echo $headerData['javascript']; ?>
        <?php echo $headerData['javascript_plugins']; ?>
        <?php echo $headerData['bottom_javascripts']; ?>

        <script>
            $(document).ready(function(){
                load_login_form('otp');
            });
            $(document).on("keypress","#mobileno",function(event) {
                if (event.which == 13){
                    event.preventDefault();
                    login_with_mobile();
                }
            });
            $(document).on("keypress","#email,#password",function(event) {
                if (event.which == 13){
                    event.preventDefault();
                    login_with_email();
                }
            });
            $(document).on("click", "#continuewithemail", function(){
                load_login_form('email');
            });
            $(document).on("click", "#continuewithmobile", function(){
                load_login_form('otp');
            });
            function login_with_mobile(){
                
                var mobileno = $("#mobileno").val().trim();
                
                var isvalid = 1;
                
                if(mobileno == ''){
                    $("#melement").addClass("manage-error");
                    toastr.error('Please enter mobile number !');
                    isvalid = 0;
                }else if(mobileno.length != 10){
                    $("#melement").addClass("manage-error");
                    toastr.error('Mobile number allowed 10 digits !');
                    isvalid = 0;
                }else{
                    $("#melement").removeClass("manage-error");
                }
                
                if(isvalid ==1){
                
                    var formData = new FormData($('#loginform')[0]);
                    $.ajax({
                        url: SITE_URL+"login/verify-user",
                        type: 'POST',
                        data: formData,
                        beforeSend: function(){
                            $("#sendotpbtn").css({"pointer-events": "none","opacity": "0.5"});
                        },
                        success: function(response){
                            $("#userid").val('');
                            if(response > 0){
                                toastr.success('OTP successfully send in your mobile number.');
                                setTimeout(function(){
                                    $("#step1").hide();
                                    $("#step2").show();
                                    $("#userid").val(response.trim());
                                    // window.location.href=SITE_URL+"otp/"+response.trim();
                                },2000);
                            }else if(response == -2){
                                toastr.error('Your account is not active !');
                            }else if(response == -4){
                                toastr.error('Login only foodies users !');
                            }else if(response == -5){
                                toastr.error('OTP not send !');
                            }else{
                                toastr.error('Invalid credential !');
                            }
                        },
                        complete: function(){
                            $("#sendotpbtn").css({"pointer-events": "unset","opacity": "1"});
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                    
                }
            }
            function login_with_email(){
                
                var email = $("#email").val().trim();
                var password = $("#password").val().trim();

                var isvalid = 1;
                
                if(email == ''){
                    $("#eelement").addClass("manage-error");
                    toastr.error('Please enter E-mail ID !');
                    isvalid = 0;
                }else if(!checkEmail(email)){
                    $("#eelement").addClass("manage-error");
                    toastr.error('Please enter valid email address !');
                    isvalid = 0;
                }else{
                    $("#eelement").removeClass("manage-error");
                }
                if(password == ''){
                    $("#pwdelement").addClass("manage-error");
                    toastr.error('Please enter password !');
                    isvalid = 0;
                }else{
                    $("#pwdelement").removeClass("manage-error");
                }
                
                if(isvalid ==1){
                
                    var formData = new FormData($('#loginform')[0]);
                    $.ajax({
                        url: SITE_URL+"login/login-with-email",
                        type: 'POST',
                        data: formData,
                        beforeSend: function(){
                            $("#continueWithEmail").css({"pointer-events": "none","opacity": "0.5"});
                        },
                        success: function(response){
                            $("#userid").val('');
                            if(response > 0){
                                toastr.success('Login successfully.');
                                setTimeout(function(){
                                    <?php if(empty($this->session->userdata('redirect_url'))) {
                                        $reditect_url = FRONT_URL;
                                    }else{ 
                                        $reditect_url = $this->session->userdata('redirect_url');
                                    } ?>  
                                    window.location.href='<?=$reditect_url?>';
                                },1500);
                            }else if(response == -2){
                                toastr.error('Your account is not active !');
                            }else if(response == -4){
                                toastr.error('Login only customers !');
                            }else{
                                toastr.error('Invalid credential !');
                            }
                        },
                        complete: function(){
                            $("#continueWithEmail").css({"pointer-events": "unset","opacity": "1"});
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                    
                }
            }
            function load_login_form(type='otp'){
                if(type=='otp'){
                    var html = '<div class="inputLabel form-group" id="melement">\
                            <input type="text" id="mobileno" name="mobileno" class="form-control form-control-up" onkeypress="return isNumeric(event)" maxlength="10" autocomplete="off" placeholder="" />\
                            <span class="placeholderContent">Enter Mobile Number</span>\
                        </div>\
                        <div class="loginButtonSection">\
                            <a href="javascript:void(0)" id="sendotpbtn" onclick="login_with_mobile()" class="sendOTPButton">Send OTP</a>\
                            <span>OR</span>\
                            <a href="javascript:void(0)" class="continueWithEmail" id="continuewithemail"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp&nbsp Continue with Email</a>\
                        </div>';
                }else if(type=='email'){
                
                    var html = '<div class="inputLabel form-group" id="eelement">\
                            <input type="text" name="email" id="email" autocomplete="off" class="form-control form-control-up" placeholder="">\
                            <span class="placeholderContent" for="email">Enter Email ID</span>\
                        </div>\
                        <div class="inputLabel form-group" id="pwdelement">\
                            <input type="password" id="password" name="password" autocomplete="off" class="form-control form-control-up" placeholder="" />\
                            <span class="placeholderContent">Enter Password</span>\
                        </div>\
                        <div class="loginButtonSection">\
                            <a href="javascript:void(0)" id="continueWithEmail" class="continueWithEmail" onclick="login_with_email()">Login</a>\
                            <span>OR</span>\
                            <a href="javascript:void(0)" id="continuewithmobile" class="sendOTPButton">Continue With Mobile</a>\
                        </div>';
                } 

                $("#login_form").html(html);
            }
            function getCodeBoxElement(index) {
                return document.getElementById('codeBox' + index);
            }
            function onKeyUpEvent(index, event) {
                const eventCode = event.which || event.keyCode;
                var otp = ""; 
                if (getCodeBoxElement(index).value.length === 1) {
                    if (index !== 4) {
                        getCodeBoxElement(index+ 1).focus();
                    } else {
                        getCodeBoxElement(index).blur();
                        // Submit code
                        // console.log('submit code ');
                        
                        $(".otptext").each(function(){
                            if(this.value!=""){
                                otp += this.value
                            }
                        });
                        $("#otp").val(otp);
                        verifyotp();
                    }
                }
                if (eventCode === 8 && index !== 1) {
                    getCodeBoxElement(index - 1).focus();
                }
                $("#otp").val(otp);
            }
            function onFocusEvent(index) {
                for (item = 1; item < index; item++) {
                    const currentElement = getCodeBoxElement(item);
                    if (!currentElement.value) {
                        currentElement.focus();
                        break;
                    }
                }
            }

            function verifyotp(){
                
                var otp = $("#otp").val().trim();
                
                var isvalid = 1;
                
                if(otp == ''){
                    toastr.error('Please enter otp !');
                    isvalid = 0;
                }
                
                if(isvalid ==1){
                
                    var formData = new FormData($('#otpform')[0]);
                    $.ajax({
                        url: SITE_URL+"login/verify-otp",
                        type: 'POST',
                        data: formData,
                        success: function(response){
                            if(response == 1){
                                toastr.success('Login successfully.');
                                setTimeout(function(){
                                    <?php if(empty($this->session->userdata('redirect_url'))) {
                                        $reditect_url = FRONT_URL;
                                    }else{ 
                                        $reditect_url = $this->session->userdata('redirect_url');
                                    } ?>  
                                    window.location.href='<?=$reditect_url?>';
                                },1500);
                            }else if(response == 2){
                                toastr.error('Please enter valid OTP !');
                            }else if(response == 3){
                                toastr.error('Your OTP was expired !');
                            }else{
                                toastr.error('Invalid OTP !');
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                    
                }
            }
            function resendotp(){
                $(".otptext").val("");
                $("#otp").val("");
                $.ajax({
                    url: SITE_URL+"login/resend-otp",
                    type: 'POST',
                    data: {userid:$("#userid").val()},
                    success: function(response){
                        if(response==1){
                            toastr.success('OTP successfully send in your mobile number.');
                        }else{
                            toastr.error('OTP not send !');
                        }
                    },
                });
            }
        </script>
        </div>
    </body>
    </html>