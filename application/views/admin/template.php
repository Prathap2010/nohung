<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<?php $headerData = $this->admin_headerlib->data(); ?>

<head>
    <meta charset="utf-8" />

    <title><?php echo $title . " - " . SITE_NAME ?></title>
    <?php echo $headerData['favicon']; ?>
    <?php echo $headerData['meta_tags']; ?>
    <?php echo $headerData['stylesheets']; ?>
    <?php echo $headerData['plugins']; ?>

    <script type="text/javascript">
        var SITE_URL = '<?php echo ADMIN_URL ?>';
        var DOMAIN_URL = '<?php echo DOMAIN_URL ?>';
        var ACTION = '<?php if (isset($action)) {
                            echo 1;
                        } else {
                            echo 0;
                        }/*1-Edit,0-Add or View*/ ?>';
    </script>
    <script src="<?php echo ADMIN_JS_URL; ?>jquery-1.10.2.min.js" type="text/javascript"></script>
    <?php echo $headerData['top_javascripts']; ?>
    <style>
        .sidebar-blue.static-sidebar-wrapper,
        .sidebar-blue.fixed-sidebar {
            background-color: #FFA451 !important;
        }

        .sidebar-blue nav.widget-body>ul.acc-menu li a {
            background-color: #FFA451 !important;
        }

        .sidebar-blue nav.widget-body>ul.acc-menu ul,
        .sidebar-blue nav.widget-body>ul.acc-menu ul li a {
            background-color: #FFA451 !important;
        }

        .sidebar-blue nav.widget-body>ul.acc-menu>li>a,
        .sidebar-blue nav.widget-body>ul.acc-menu>li>a span.icon {
            color: #fff !important;
        }

        .sidebar-blue nav.widget-body>ul.acc-menu>li.active>a,
        .sidebar-blue nav.widget-body>ul.acc-menu>li:hover>a {
            background-color: #EF7B13 !important;
            color: #fff !important;
        }

        .sidebar-blue nav.widget-body>ul.acc-menu>li.active>a span.icon,
        .sidebar-blue nav.widget-body>ul.acc-menu>li:hover>a span.icon {
            color: #fff !important;
        }

        .sidebar-blue nav.widget-body>ul.acc-menu ul,
        .sidebar-blue nav.widget-body>ul.acc-menu ul li a {
            color: #fff;
        }

        .sidebar-blue nav.widget-body>ul.acc-menu ul li a:hover {
            background-color: #EF7B13 !important;
            color: #fff !important;
        }

        .sidebar-blue nav.widget-body>ul.acc-menu ul li.active:not(.open)>a {
            background-color: #EF7B13 !important;
            color: #fff !important;
        }



        /* .sidebar .widget .widget-body .userinfo .info .username{
                color: rgb(0 0 0 / 87%);
            } */
        .btn.btn-raised.btn-primary,
        .input-group-btn .btn.btn-raised.btn-primary,
        .btn.btn-fab.btn-primary,
        .input-group-btn .btn.btn-fab.btn-primary,
        .btn-group-raised .btn.btn-primary,
        .btn-group-raised .input-group-btn .btn.btn-primary {
            background-color: #EF7B13 !important;
        }

        .btn-file {
            margin-right: 0px !important;
        }

        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }
    </style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<?php
if (!empty($this->session->userdata(base_url() . 'SIDEBAR_COLLAPASED'))) {
    $sidebar_class = $this->session->userdata(base_url() . 'SIDEBAR_COLLAPASED');
} else {
    $sidebar_class = "sidebar-scroll";
}
?>

<body class="infobar-overlay page-md page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo <?= $sidebar_class ?>">
    <!-- BEGIN PAGE LOADER -->
    <div class="mask">
        <div id="loader"></div>
    </div>
    <!-- END PAGE LOADER -->
    <!-- BEGIN HEADER -->
    <?php $this->load->view(ADMINFOLDER . 'includes/header'); ?>
    <!-- END HEADER -->

    <!-- BEGIN CONTAINER -->
    <div id="wrapper">
        <div id="layout-static">
            <div class="static-sidebar-wrapper sidebar-blue">
                <?php $this->load->view(ADMINFOLDER . 'includes/sidebar'); ?>
            </div>
            <!-- BEGIN CONTENT -->

            <div class="static-content-wrapper">
                <div class="static-content">
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <?php $this->load->view(ADMINFOLDER . $module); ?>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
            <!-- END CONTENT -->

        </div>
    </div>
    <!-- END CONTAINER -->

    <?php echo $headerData['javascript']; ?>
    <?php echo $headerData['javascript_plugins']; ?>
    <?php echo $headerData['bottom_javascripts']; ?>
    <script src="<?php echo ADMIN_JS_URL; ?>application.js" type="text/javascript"></script>

</body>
<!-- END BODY -->

</html>