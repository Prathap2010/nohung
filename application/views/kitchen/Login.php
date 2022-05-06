<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<?php $headerData = $this->kitchen_headerlib->data(); ?>

<head>
    <title><?php echo $title . " - " . SITE_NAME; ?></title>
    <meta charset="UTF-8">
    <?php echo $headerData['meta_tags']; ?>
    <?php echo $headerData['favicon']; ?>
    <?php echo $headerData['stylesheets']; ?>
    <?php echo $headerData['plugins']; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />

    <?php echo $headerData['top_javascripts']; ?>
    <script>
        var SITE_URL = '<?php echo KITCHEN_URL ?>';
        var KITCHEN_IMAGES_URL = '<?php echo KITCHEN_IMAGES_URL ?>';
    </script>
    <style>
        .manage-error .form-control,
        .manage-error .bootstrap-select button {
            border: 1px solid #fe0d0d !important;
        }
    </style>
</head>

<body>
    <div class="loginBackground">
        <div class="loginBackgroundOverlay"></div>
        <div class="loginContainer">
            <div class="cookManSection">
                <img src="<?= KITCHEN_IMAGES_URL ?>cookMan.svg" alt="">
            </div>
            <div class="loginContents">
                <form action="#" id="loginform" class="form-horizontal">
                    <div class="loginLogo">
                        <img src="<?= KITCHEN_IMAGES_URL ?>logo.svg" alt="logo">
                    </div>
                    <div class="loginHeading">
                        <h2>LOGIN</h2>
                    </div>
                    <div class="formContents">
                        <h3>Welcome back,</h3>
                        <div class="form-group" id="kidelement">
                            <input type="text" id="kitchenid" name="kitchenid" autocomplete="off" class="form-control">
                            <label for="kitchenid">Kitchen ID</label>
                        </div>
                        <div class="form-group" id="pwdelement">
                            <input type="password" id="password" name="password" autocomplete="off" class="form-control">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-group loginbuttonsSections">
                            <a href="<?= KITCHEN_URL ?>forgot-password" class="forgotPasswordText">Forgot Password?</a>
                            <a href="javascript:void(0)" onclick="login()" class="loginButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                    <defs>
                                        <style>
                                            .a {
                                                fill: #fff;
                                            }
                                        </style>
                                    </defs>
                                    <path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)" />
                                </svg>
                            </a>
                        </div>
                        <!-- <p>Are you foodies ? <a href="<?= KITCHEN_URL ?>">Click Here</a></p> -->
                    </div>
                    <div class="dontHaveAccount">
                        <p>Don't have an account yet? Start taking orders NOW by <a href="<?= KITCHEN_URL ?>register">SIGNING UP!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php echo $headerData['javascript']; ?>
    <?php echo $headerData['javascript_plugins']; ?>
    <?php echo $headerData['bottom_javascripts']; ?>

    <script>
        function login() {

            var kitchenid = $("#kitchenid").val().trim();
            var password = $("#password").val().trim();

            var isvalid = 1;

            if (kitchenid == '') {
                $("#kidelement").addClass("manage-error");
                toastr.error('Please enter Kitchen ID !');
                isvalid = 0;
            } else {
                $("#kidelement").removeClass("manage-error");
            }
            if (password == '') {
                $("#pwdelement").addClass("manage-error");
                toastr.error('Please enter Password !');
                isvalid = 0;
            } else {
                $("#pwdelement").removeClass("manage-error");
            }

            if (isvalid == 1) {

                var formData = new FormData($('#loginform')[0]);
                $.ajax({
                    url: SITE_URL + "login/verify-user",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response == 1) {
                            toastr.success('Login successfully.');
                            setTimeout(function() {
                                window.location.href = SITE_URL;
                            }, 1500);
                        } else if (response == 2) {
                            toastr.error('Your account is not active !');
                        } else if (response == 3) {
                            toastr.error('Your account is not approve !');
                        } else if (response == 4) {
                            toastr.error('Login only kitchen users !');
                        } else {
                            toastr.error('Invalid credential !');
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        }
        $(document).ready(function() {
            $("input").keypress(function(event) {
                if (event.which == 13) {
                    event.preventDefault();
                    login();
                }
            });
        });
    </script>
</body>

</html>