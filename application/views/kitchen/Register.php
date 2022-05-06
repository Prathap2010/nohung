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
        .manage-error .form-control/* ,
        .manage-error .bootstrap-select button */ {
            border: 1px solid #fe0d0d !important;
        }

        .bootstrap-select button {
            border: 1px solid #CFCFCF;
        }

        .filter-option {
            font-size: 15px;
            padding: 6px;
        }

        .bootstrap-select li span.text {
            font-size: 15px;
        }

        .reg-form-inner {
            max-height: 230px;
        }
        /*Style By Harshad Start*/	
        .nh-login-content.loginBackground .loginContainer .loginContents form .loginHeading {	
            padding-left: 0;	
            padding-right: 0;	
            padding-bottom: 0;	
        }	
        .nh-login-content.loginBackground .loginContainer .loginContents form .loginHeading h2 {	
            padding-left: 50px;	
            padding-right: 50px;	
        }	
        .nh-login-content.loginBackground .loginContainer .loginContents form .loginHeading h2::before {	
            left: 50px;	
        }	
        .nh-login-form__inner {	
            padding-left: 50px;	
            padding-right: 50px;	
        }	
        .nh-login-content .regformcontent {	
            padding: 0 !important;	
        }	
        .nh-login-content .reg-form-inner {	
            max-height: unset;	
            overflow-y: unset;	
        }	
        .nh-login-content .nh-login-form {	
            max-height: 460px;	
            overflow-y: auto;	
            overflow-x: hidden;	
             -ms-overflow-style: none;	
             scrollbar-width: none;	
             -ms-overflow-style: none;  /* IE and Edge */	
            scrollbar-width: none;  /* Firefox */	
        }	
        .nh-login-content .nh-login-form::-webkit-scrollbar {	
            display: none;	
        }	
        .nh-login-content.loginBackground .loginContainer .loginContents form .formContents h4 {	
            margin-bottom: 10px;	
            background-color: #fff;	
            position: sticky;	
            top: 0;	
            left: 0;	
            z-index: 10;	
            padding-bottom: 20px;	
        }	
        /*Style By Harshad End*/
    </style>
</head>

<body>
    <div class="loginBackground nh-login-content">
        <div class="loginBackgroundOverlay"></div>
        <div class="loginContainer">
            <div class="cookManSection">
                <img src="<?= KITCHEN_IMAGES_URL ?>cookMan.svg" alt="">
            </div>
            <div class="loginContents">
                <form action="#" id="userform" class="form-horizontal" enctype="multipart/form-data">
                    <div class="loginLogo">
                        <img src="<?= KITCHEN_IMAGES_URL ?>logo.svg" alt="logo">
                    </div>
                    <div class="loginHeading">
                        <h2><?php echo $title; ?></h2>
                        <div class="formContents regformcontent">
                            <div class="step1">
                                <div class="nh-login-form">	
                                    <div class="nh-login-form__inner">
                                        <h4>Please provide basic details:</h4>
                                        <div class="reg-form-inner">
                                            <div class="form-group" id="knelement">
                                                <input type="text" name="kitchenname" id="KitchenName" autocomplete="off" class="form-control">
                                                <label for="KitchenName">Kitchen Name</label>
                                            </div>
        
        
                                            <div class="form-group" id="addelement">
                                                <input type="text" name="address" id="KitchenAddress" autocomplete="off" class="form-control">
                                                <label for="KitchenAddress">Kitchen Address</label>
                                            </div>
        
                                            <div class="form-group" id="stelement">
                                                <!-- <input type="text" id="State" autocomplete="off" class="form-control"> -->
                                                <!-- <label for="State">State</label> -->
                                                <select name="stateid" id="stateid" class="selectpicker form-control" data-live-search="true" data-size="5">
                                                    <option value="0">Select State</option>
                                                    <?php if (!empty($provincedata)) {
                                                        foreach ($provincedata as $state) { ?>
                                                            <option value="<?= $state['id'] ?>"><?= $state['name'] ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
        
                                            <div class="form-group" id="ctelement">
                                                <!-- <input type="text" id="City" autocomplete="off" class="form-control"> -->
                                                <!-- <label for="City">City</label> -->
                                                <select name="cityid" id="cityid" class="selectpicker form-control" data-live-search="true" data-size="5">
                                                    <option value="0">Select City</option>
                                                    <?php if (!empty($citydata)) {
                                                        foreach ($citydata as $city) { ?>
                                                            <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
        
                                            </div>
        
                                            <div class="form-group" id="pcelement">
                                                <input type="text" id="pincode" name="pincode" autocomplete="off" class="form-control" onkeypress="return isNumeric(event);">
                                                <label for="pincode">Pincode</label>
                                            </div>
        
                                            <div class="form-group" id="cnelement">
                                                <input type="text" id="contact-name" name="contactname" autocomplete="off" class="form-control">
                                                <label for="contact-name">Contact Person's Name</label>
                                            </div>
        
                                            <div class="form-group" id="rlelement">
                                                <input type="text" id="role" name="role" autocomplete="off" class="form-control">
                                                <label for="role">Contact Person's Role</label>
                                            </div>
        
                                            <div class="form-group" id="mnelement">
                                                <input type="text" id="mobile-number" name="mobilenumber" autocomplete="off" class="form-control" onkeypress="return isNumeric(event);">
                                                <label for="mobile-number">Mobile Number</label>
                                            </div>
        
                                            <div class="form-group" id="kcnelement">
                                                <input type="text" id="kitchencontactnumber" name="kitchencontactnumber" autocomplete="off" class="form-control" onkeypress="return isNumeric(event);">
                                                <label for="kitchencontactnumber">Kitchen's Contact Number</label>
                                            </div>
        
                                            <div class="form-group" id="emailelement">
                                                <input type="text" name="email" id="email" autocomplete="off" class="form-control">
                                                <label for="email">Email Id</label>
                                            </div>
                                        </div>
                                        <div class="form-group loginbuttonsSections">
                                            <a style="visibility: hidden;" href="" class="forgotPasswordText">Forgot Password?</a>
                                            <a href="javascript:void(0)" onclick="checkstepone()" class="loginButton">
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
                                    </div>
                                    <div class="dontHaveAccount">
                                        <p>Already having an account yet? <a href="<?= KITCHEN_URL ?>login">SIGN IN NOW</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="step2" style="display: none;">
                                <div class="nh-login-form">
                                    <div class="nh-login-form__inner">
                                        <h4>Please provide business details:</h4>
                                        <div class="reg-form-inner">
                                            <div class="form-row">
                                                <div class="form-group" id="fssaielement">
                                                    <input type="text" id="fssai" name="fssai" autocomplete="off" class="form-control">
                                                    <label for="fssai">FSSAI License No.</label>
                                                </div>

                                                <div class="form-group" id="edelement">
                                                    <input type="text" id="expiry-date" name="expirydate" autocomplete="off" class="form-control">
                                                    <label for="expiry-date">Expiry Date</label>
                                                </div>
                                            </div>

                                            <div class="form-group" id="panelement">
                                                <input type="text" id="pan" name="panno" autocomplete="off" class="form-control">
                                                <label for="pan">PAN Card</label>
                                            </div>

                                            <div class="form-group" id="gstelement">
                                                <input type="text" id="gst" name="gstno" autocomplete="off" class="form-control">
                                                <label for="gst">GST Registration No.</label>
                                            </div>

                                            <div class="form-row custom-form-row">
                                                <span class="custom-lbl">Upload Documents</span>
                                                <div class="upload-btn-wrapper">
                                                    <input type="hidden" id="isvaliddocuments" value="0">
                                                    <button class="btn">Upload</button>
                                                    <input type="file" id="documents" name="documents[]" multiple="multiple" accept=".jpg,.png,.gif,.pdf" onchange="check_file($(this),'documents')" />
                                                </div>
                                                <a href="#" data-toggle="popover" data-trigger="hover" data-content="Please upload the documents in pdf format">
                                                    <img src="<?= KITCHEN_IMAGES_URL ?>info-ico.svg" style="height: 25px; width: 25px;">
                                                </a>
                                                <div class="imp-msg">Required Documents: PAN Card, FSSAI Certificate, GST Certificate, Business Address Proof</div>
                                            </div>

                                            <div class="form-row custom-form-row" style="padding-top: 20px; padding-bottom: 0;">
                                                <span class="custom-lbl">Upload Menu</span>
                                                <div class="upload-btn-wrapper">
                                                    <input type="hidden" id="isvalidmenufile" value="0">
                                                    <button class="btn">Upload</button>
                                                    <input type="file" id="menufile" name="menufile" accept=".jpg,.png,.gif,.pdf" onchange="check_file($(this),'menufile')" />
                                                </div>
                                                <a href="#" data-toggle="popover" data-trigger="hover" data-content="You can upload your menu in PNG, JPEG or PDF format">
                                                    <img src="<?= KITCHEN_IMAGES_URL ?>info-ico.svg" style="height: 25px; width: 25px;">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group loginbuttonsSections">
                                            <a href="javascript:void(0)" class="forgotPasswordText backnew">Previous</a>
                                            <a href="javascript:void(0)" onclick="register()" class="loginButton">
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
                                    </div>
                                    <div class="dontHaveAccount">
                                        <p>Already having an account yet? <a href="<?= KITCHEN_URL ?>login">SIGN IN NOW</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="dontHaveAccount">
                        <p>Already having an account yet? <a href="<?= KITCHEN_URL ?>login">SIGN IN NOW</a></p>
                    </div> -->
                </form>
            </div>
        </div>
    </div>

    <?php echo $headerData['javascript']; ?>
    <?php echo $headerData['javascript_plugins']; ?>
    <?php echo $headerData['bottom_javascripts']; ?>

    <script>
        $(document).ready(function() {

            $('#stateid').on('change', function(e) {
                getcity(this.value);
            });
            $('.backnew').click(function() {
                $(".step1").show();
                $(".step2").hide();
            });
            $('#expiry-date').datepicker({
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayBtn: "linked"
            });
        });

        function check_file(obj, element) {
            var val = obj.val();
            var id = obj.attr('id').match(/\d+/);
            var filename = obj.val().replace(/C:\\fakepath\\/i, '');
            var filesize = obj[0].files[0].size;

            switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                case 'bmp':

                    $("#isvalid" + element).val(1);
                    break;
                default:

                    $("#isvalid" + element).val(0);
                    if (element == 'documents') {
                        toastr.error('Accept documents only PDF & image format !');
                    } else {
                        toastr.error('Accept menu file only PDF & image format !');
                    }
                    break;
            }
        }

        function getcity(provinceid) {

            $('#cityid')
                .find('option')
                .remove()
                .end()
                .append('<option value="0">Select City</option>')
                .val('0');
            $('#cityid').selectpicker('refresh');
            if (provinceid != "") {

                $.ajax({
                    url: "<?php echo DOMAIN_URL ?>process/getCityData",
                    type: 'POST',
                    data: {
                        provinceid: provinceid
                    },
                    dataType: 'json',
                    async: false,
                    success: function(response) {

                        for (var i = 0; i < response.length; i++) {
                            $('#cityid').append($('<option>', {
                                value: response[i]['id'],
                                text: response[i]['name']
                            }));
                        }
                    },
                    error: function(xhr) {
                        //alert(xhr.responseText);
                    },
                });
            }
            $('#cityid').selectpicker('refresh');
        }

        function checkstepone() {

            var kitchenname = $("#KitchenName").val().trim();
            var address = $("#KitchenAddress").val().trim();
            var email = $("#email").val().trim();
            var stateid = $("#stateid").val();
            var cityid = $("#cityid").val();
            var pincode = $("#pincode").val();
            var contactname = $("#contact-name").val();
            var role = $("#role").val();
            var mobilenumber = $("#mobile-number").val();
            var kitchencontactnumber = $("#kitchencontactnumber").val();

            var isvalid = 1;

            if (kitchenname == '') {
                $("#knelement").addClass("manage-error");
                toastr.error('Please enter kitchen name !');
                isvalid = 0;
            } else {
                $("#knelement").removeClass("manage-error");
            }
            if (email == '') {
                $("#emailelement").addClass("manage-error");
                toastr.error('Please enter email !');
                isvalid = 0;
            } else if (email != '' && !checkEmail(email)) {
                $("#emailelement").addClass("manage-error");
                toastr.error('Email address is not valid !');
                isvalid = 0;
            } else {
                $("#emailelement").removeClass("manage-error");
            }
            if (address == '') {
                $("#addelement").addClass("manage-error");
                toastr.error('Please enter kitchen address !');
                isvalid = 0;
            } else {
                $("#addelement").removeClass("manage-error");
            }
            if (stateid == 0) {
                $("#stelement").addClass("manage-error");
                toastr.error('Please select state !');
                isvalid = 0;
            } else {
                $("#stelement").removeClass("manage-error");
            }
            if (cityid == 0) {
                $("#ctelement").addClass("manage-error");
                toastr.error('Please select city !');
                isvalid = 0;
            } else {
                $("#ctelement").removeClass("manage-error");
            }
            if (pincode == '') {
                $("#pcelement").addClass("manage-error");
                toastr.error('Please enter pincode !');
                isvalid = 0;
            } else {
                $("#pcelement").removeClass("manage-error");
            }
            if (contactname == '') {
                $("#cnelement").addClass("manage-error");
                toastr.error('Please enter contact person\'s name !');
                isvalid = 0;
            } else {
                $("#cnelement").removeClass("manage-error");
            }
            if (role == '') {
                $("#rlelement").addClass("manage-error");
                toastr.error('Please enter contact person\'s role !');
                isvalid = 0;
            } else {
                $("#rlelement").removeClass("manage-error");
            }
            if (mobilenumber == '') {
                $("#mnelement").addClass("manage-error");
                toastr.error('Please enter mobile number !');
                isvalid = 0;
            } else if (mobilenumber.length != 10) {
                $("#mnelement").addClass("manage-error");
                toastr.error('Mobile number required 10 digits !');
                isvalid = 0;
            } else {
                $("#mnelement").removeClass("manage-error");
            }
            if (kitchencontactnumber == '') {
                $("#kcnelement").addClass("manage-error");
                toastr.error('Please enter kitchen\'s contact number !');
                isvalid = 0;
            } else if (kitchencontactnumber.length != 10) {
                $("#kcnelement").addClass("manage-error");
                toastr.error('Allow 10 digits number of kitchen\'s contact number');
                isvalid = 0;
            } else {
                $("#kcnelement").removeClass("manage-error");
            }

            if (isvalid == 1) {

                $(".step1").hide();
                $(".step2").show();

            }
        }

        function register() {

            var fssai = $("#fssai").val().trim();
            var expirydate = $("#expiry-date").val().trim();
            var pan = $("#pan").val().trim();
            var gst = $("#gst").val();
            var documents = $("#documents").val();
            var isvaliddocuments = $("#isvaliddocuments").val();
            var menufile = $("#menufile").val();
            var isvalidmenufile = $("#isvalidmenufile").val();

            var isvalid = 1;
            if (fssai == '') {
                $("#fssaielement").addClass("manage-error");
                toastr.error('Please enter FSSAI license no. !');
                isvalid = 0;
            } else if (fssai != '' && fssai.length != "14") {
                $("#fssaielement").addClass("manage-error");
                toastr.error('FSSAI license no. required 14 digits !');
                isvalid = 0;
            } else {
                $("#fssaielement").removeClass("manage-error");
            }
            if (expirydate == '') {
                $("#edelement").addClass("manage-error");
                toastr.error('Please enter expiry date !');
                isvalid = 0;
            } else {
                $("#edelement").removeClass("manage-error");
            }
            if (pan == '') {
                $("#panelement").addClass("manage-error");
                toastr.error('Please enter PAN card !');
                isvalid = 0;
            } else {
                $("#panelement").removeClass("manage-error");
            }
            if (gst == '') {
                $("#gstelement").addClass("manage-error");
                toastr.error('Please enter GST registration no. !');
                isvalid = 0;
            } else {
                $("#gstelement").removeClass("manage-error");
            }
            if (documents == '' && isvaliddocuments == 0) {
                toastr.error('Please upload documents !');
                isvalid = 0;
            } else if (documents != '' && isvaliddocuments == 0) {
                toastr.error('Accept documents only PDF & image format !');
                isvalid = 0;
            }
            if (menufile == '' && isvalidmenufile == 0) {
                toastr.error('Please upload menu !');
                isvalid = 0;
            } else if (menufile != '' && isvalidmenufile == 0) {
                toastr.error('Accept menu file only PDF & image format !');
                isvalid = 0;
            }
            if (isvalid == 1) {

                var formData = new FormData($('#userform')[0]);
                $.ajax({
                    url: SITE_URL + "register/new-register",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response == 1) {
                            toastr.success('Register detail submit successfully.');
                            setTimeout(function() {
                                window.location.href = SITE_URL + "login";
                            }, 2000);
                        } else if (response == 2) {
                            toastr.error('Email already register !');
                        } else if (response == 3) {
                            toastr.error('Mobile number already register !');
                        } else if (response == 0) {
                            toastr.error('Register detail not submit !');
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        }
    </script>
</body>

</html>