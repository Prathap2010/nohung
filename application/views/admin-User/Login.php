<?php 
$this->admin_headerlib->add_stylesheet("login-css","pages/login.css");
$this->admin_headerlib->add_javascript("login","pages/login.js");
$headerData = $this->admin_headerlib->data();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
  <!-- BEGIN HEAD -->
  <?php $headerData = $this->admin_headerlib->data(); ?>
    <head>
        <meta charset="utf-8" />

        <title><?php echo $title." - ".SITE_NAME ?></title>
        <?php echo $headerData['favicon']; ?>
        <?php echo $headerData['meta_tags']; ?>
        <?php echo $headerData['stylesheets']; ?>
        <?php echo $headerData['plugins']; ?>
        <script type="text/javascript">
            var SITE_URL = '<?php echo ADMIN_URL ?>';
            var ACTION = '<?php if(isset($action)){ echo 1; }else{ echo 0; }/*1-Edit,0-Add or View*/ ?>';
        </script>
        <script src="<?php echo ADMIN_JS_URL;?>jquery-1.10.2.min.js" type="text/javascript"></script>
        <?php echo $headerData['top_javascripts']; ?>
        <style>
          .btn.btn-raised.btn-primary, .input-group-btn .btn.btn-raised.btn-primary, .btn.btn-fab.btn-primary, .input-group-btn .btn.btn-fab.btn-primary, .btn-group-raised .btn.btn-primary, .btn-group-raised .input-group-btn .btn.btn-primary {
                background-color: #EF7B13 !important;
          }
        </style>
    </head>
  <!-- END HEAD -->
  
  <body class="focused-form animated-content">
    <!-- BEGIN PAGE LOADER -->    
    <div class="mask">
      <div id="loader"></div>
    </div>
    <!-- END PAGE LOADER -->
    <div class="container" id="login-form">
        <div class="row" style="margin-top: 100px;">
          <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default" style="border-radius: 0px;">
              <div class="panel-heading">
                <h2><?=SITE_NAME?> Login</h2>
              </div>
              <div class="panel-body">
                
                <form class="form-horizontal" method="post" id="validate-form">
                  <div class="form-group mb-md" id="email_div">
                    <div class="col-md-12">
                      <label class="control-label mb-xs" for="loginEmail"><i class="fa fa-user fa-lg"></i> Email ID</label>
                      <input id="loginEmail" class="form-control" name="loginEmail" type="text" tabindex="1">
                    </div>
                  </div>

                  <div class="form-group mb-md" id="password_div">
                    <div class="col-md-12">
                      <label class="control-label mb-xs" for="loginPassword"><i class="fa fa-lock fa-lg"></i> Password</label>
                      <input type="password" class="form-control" id="loginPassword" name="loginPassword" tabindex="2">
                      <i class="fa fa-eye eye fa-lg" aria-hidden="true" onClick="showPassword('loginPassword')"></i>
                    </div>
                  </div>
                  <div class="form-group mb-n">
                    <div class="col-xs-12 text-center">
                      <a href="javascript:void(0);" onclick="checkLogin();" id="btnloginsubmit" class="btn btn-primary btn-raised" style="width:100%;">Login</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
    <?php echo $headerData['javascript']; ?>
    <?php echo $headerData['javascript_plugins']; ?>
    <?php echo $headerData['bottom_javascripts']; ?>
    <script src="<?php echo ADMIN_JS_URL;?>application.js" type="text/javascript"></script>
   
  </body>
</html>