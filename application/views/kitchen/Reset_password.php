<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <?php $headerData = $this->kitchen_headerlib->data(); ?>
    <head>
        <title><?php echo $title." - ".SITE_NAME;?></title>
        <meta charset="UTF-8">
        <?php echo $headerData['meta_tags']; ?>
        <?php echo $headerData['favicon']; ?>
        <?php echo $headerData['stylesheets']; ?>
        <?php echo $headerData['plugins']; ?>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
      
        <?php echo $headerData['top_javascripts']; ?>
        <script>
            var SITE_URL = '<?php echo KITCHEN_URL ?>';
        </script>
        <style>
            .manage-error .form-control,.manage-error .bootstrap-select button{
                border: 1px solid #fe0d0d !important;
            }
        </style>
    </head>
    <body>
        <div class="loginBackground">
            <div class="loginBackgroundOverlay"></div>
            <div class="loginContainer">
                <div class="cookManSection">
                    <img src="<?= KITCHEN_IMAGES_URL?>cookMan.svg" alt="cookMan">
                </div>
                <div class="loginContents">
                    <form action="#" id="resetpwdform" class="form-horizontal">
                        <input type="hidden" name="userid" id="userid" value="<?php echo $resetdata['userid']; ?>">
                        <input type="hidden" name="authid" id="authid" value="<?php echo $resetdata['id']; ?>">
                        <div class="loginLogo">
                            <img src="<?= KITCHEN_IMAGES_URL?>logo.svg" alt="logo">
                        </div>
                        <div class="loginHeading">
                            <h2>Reset Password</h2>
                        </div>
                        <div class="formContents">
                            <div class="form-group" id="newpwdelement">
                                <input type="password" id="newpassword" name="newpassword" autocomplete="off" class="form-control">
                                <label for="newpassword">New Password</label>
                            </div>
                            <div class="form-group" id="cpwdelement">
                                <input type="password" id="confirmpassword" name="confirmpassword" autocomplete="off" class="form-control">
                                <label for="confirmpassword">Confirm Password</label>
                            </div>
                            <div class="form-group loginbuttonsSections">
                                <a href="<?=KITCHEN_URL?>login" class="forgotPasswordText">Back to Login</a>
                                <a href="javascript:void(0)" onclick="resetpassword()" class="loginButton">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5"><defs><style>.a{fill:#fff;}</style></defs><path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="dontHaveAccount">
                            <p>Don't have an account yet? Start taking orders NOW by <a href="<?=KITCHEN_URL?>register">SIGNING UP!</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
        <?php echo $headerData['javascript']; ?>
        <?php echo $headerData['javascript_plugins']; ?>
        <?php echo $headerData['bottom_javascripts']; ?>

        <script>
            function resetpassword(){
                
                var newpassword = $("#newpassword").val().trim();
                var confirmpassword = $("#confirmpassword").val().trim();
                
                var isvalid = 1;
                
                if(newpassword == ''){
                    $("#newpwdelement").addClass("manage-error");
                    toastr.error('Please enter Kitchen ID !');
                    isvalid = 0;
                }else{
                    $("#newpwdelement").removeClass("manage-error");
                }
                if(confirmpassword == ''){
                    $("#cpwdelement").addClass("manage-error");
                    toastr.error('Please enter confirm password !');
                    isvalid = 0;
                }else if(confirmpassword != '' && confirmpassword!=newpassword){
                    $("#cpwdelement").addClass("manage-error");
                    toastr.error('Confirm password does not match with password !');
                    isvalid = 0;
                }else{
                    $("#cpwdelement").removeClass("manage-error");
                }
                
                if(isvalid ==1){
                
                    var userid = $("#userid").val();
                    var authid = $("#authid").val();
                    var password = $("#newpassword").val().trim();

                    $.ajax({
                        url: SITE_URL+'reset-password/update-password',
                        type: 'POST',
                        data: {password: password,userid: userid,authid: authid},
                        datatype:'json',
                        success: function(data){
                            toastr.success('Password Reset Successfully !');
                            setTimeout(function(){ window.location.href = SITE_URL; }, 4000);
                        }
                    });
                    
                }
            }
        </script>
    </body>
</html>
