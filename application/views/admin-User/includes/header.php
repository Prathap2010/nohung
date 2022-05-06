<header id="topnav" class="navbar navbar-default navbar-fixed-top" role="banner">

  <div class="logo-area">
    <a class="navbar-brand navbar-brand-default" href="<?=ADMIN_URL.'dashboard'?>">
      <img class="show-on-collapse img-logo-white" alt="Paper" src="<?=MAIN_LOGO_IMAGE_URL.SITE_FAVICON;?>">
      <img class="show-on-collapse img-logo-dark" alt="Paper" src="<?=MAIN_LOGO_IMAGE_URL.SITE_FAVICON;?>">
      <img class="img-white" alt="<?=SITE_NAME?>" src="<?=MAIN_LOGO_IMAGE_URL.SITE_LOGO;?>" style="width: auto;">
      <img class="img-dark" alt="<?=SITE_NAME?>" src="<?=MAIN_LOGO_IMAGE_URL.SITE_LOGO;?>" style="width: auto;">
    </a>

    <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg stay-on-search">
      <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar" onclick="setsidebarcollapsed()">
        <span class="icon-bg">
          <i class="material-icons">menu</i>
        </span>
      </a>
    </span>
    
    
  </div><!-- logo-area -->

  <ul class="nav navbar-nav toolbar pull-right">

    <li class="dropdown toolbar-icon-bg" id="trigger-infobar">
      <a class="hasnotifications dropdown-toggle" data-toggle='dropdown'>
        <span class="icon-bg">
          <i class="material-icons">settings</i>
        </span>
      </a>
      <div class="dropdown-menu animated notifications">
        <div class="scroll-pane">
          <ul class="media-list scroll-content">
            <li class="media notification-success">
              <a href="<?php echo ADMIN_URL; ?>user/edit-profile">
                <div class="media-left">
                  <span><i class="fa fa-user fa-lg"></i></span>
                </div>
                <div class="media-body">
                  <h4 class="notification-heading">Edit Profile</h4>
                </div>
              </a>
            </li>
            <li class="media notification-success">
              <a href="<?php echo ADMIN_URL; ?>user/change-password">
                <div class="media-left">
                  <span><i class="fa fa-key fa-lg"></i></span>
                </div>
                <div class="media-body">
                  <h4 class="notification-heading">Change Password</h4>
                </div>
              </a>
            </li>
            <li class="media notification-success">
              <a href="<?php echo ADMIN_URL; ?>site-setting">
                <div class="media-left">
                  <span><i class="fa fa-cog fa-lg"></i></span>
                </div>
                <div class="media-body">
                  <h4 class="notification-heading">Site Setting</h4>
                </div>
              </a>
            </li>
            <li class="media notification-success">
              <a href="<?php echo ADMIN_URL; ?>logout">
                <div class="media-left">
                  <span><i class="fa fa-sign-out fa-lg"></i></span>
                </div>
                <div class="media-body">
                  <h4 class="notification-heading">Logout</h4>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </li>
    
  </ul>

</header>
