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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
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

        /* DATATABLE PAGINATION STYLE START */
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 18px 0;
            border-radius: 2px;
        }

        .pagination>li {
            display: inline;
        }

        .pagination>li>a,
        .pagination>li>span {
            position: relative;
            float: left;
            padding: 5px 10px;
            line-height: 1.45;
            text-decoration: none;
            color: #03a9f4;
            background-color: #fff;
            border: 1px solid #eeeeee;
            margin-left: -1px;
        }

        .pagination>li:first-child>a,
        .pagination>li:first-child>span {
            margin-left: 0;
            border-bottom-left-radius: 2px;
            border-top-left-radius: 2px;
        }

        .pagination>li:last-child>a,
        .pagination>li:last-child>span {
            border-bottom-right-radius: 2px;
            border-top-right-radius: 2px;
        }

        .pagination>li>a:hover,
        .pagination>li>span:hover,
        .pagination>li>a:focus,
        .pagination>li>span:focus {
            color: #03a9f4;
            background-color: #e0e0e0;
            border-color: #ddd;
        }

        .pagination>.active>a,
        .pagination>.active>span,
        .pagination>.active>a:hover,
        .pagination>.active>span:hover,
        .pagination>.active>a:focus,
        .pagination>.active>span:focus {
            z-index: 2;
            color: #fff;
            background-color: #03a9f4;
            border-color: #03a9f4;
            cursor: default;
        }

        .pagination>.disabled>span,
        .pagination>.disabled>span:hover,
        .pagination>.disabled>span:focus,
        .pagination>.disabled>a,
        .pagination>.disabled>a:hover,
        .pagination>.disabled>a:focus {
            color: #848484;
            background-color: #fff;
            border-color: #ddd;
            cursor: not-allowed;
        }

        .pagination-lg>li>a,
        .pagination-lg>li>span {
            padding: 6px 12px;
            font-size: 15px;
        }

        .pagination-lg>li:first-child>a,
        .pagination-lg>li:first-child>span {
            border-bottom-left-radius: 2px;
            border-top-left-radius: 2px;
        }

        .pagination-lg>li:last-child>a,
        .pagination-lg>li:last-child>span {
            border-bottom-right-radius: 2px;
            border-top-right-radius: 2px;
        }

        .pagination-sm>li>a,
        .pagination-sm>li>span {
            padding: 3px 6px;
            font-size: 11px;
        }

        .pagination-sm>li:first-child>a,
        .pagination-sm>li:first-child>span {
            border-bottom-left-radius: 2px;
            border-top-left-radius: 2px;
        }

        .pagination-sm>li:last-child>a,
        .pagination-sm>li:last-child>span {
            border-bottom-right-radius: 2px;
            border-top-right-radius: 2px;
        }

        /* DATATABLE PAGINATION STYLE END */

        /* LOAD MORE BUTTON STYLE START */
        .load_more_btn {
            text-align: center;
            margin-top: 50px;
        }

        .load_more_btn {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 100px;
        }

        .load_more_btn a {
            text-decoration: none;
            font-size: 20px;
            color: #000000;
            font-weight: bold;
            text-transform: uppercase;
            border: solid 2px #000000;
            padding: 10px 30px;
            border-radius: 30px;
            transition: all 0.5s ease;
        }

        .load_more_btn a:hover {
            background-color: #FCC647;
            color: #FFFFFF;
            border-color: #FCC647;
            transition: all 0.5s ease;
        }

        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* LOAD MORE BUTTON STYLE END */
        .tab-content .meal-tab .nav.nav-tabs li a:hover, .tab-content .meal-tab .nav.nav-tabs li a.active {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="outerSectionLayout">
        <?php $this->load->view(KITCHENFOLDER . 'includes/sidebar'); ?>
        <div class="rightSideSection">
            <?php $this->load->view(KITCHENFOLDER . 'includes/header'); ?>
            <?php $this->load->view(KITCHENFOLDER . $module); ?>
        </div>
        <?php //$this->load->view(KITCHENFOLDER.'includes/footer');
        ?>

        <?php echo $headerData['javascript']; ?>
        <?php echo $headerData['javascript_plugins']; ?>
        <?php echo $headerData['bottom_javascripts']; ?>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    </div>
</body>

</html>