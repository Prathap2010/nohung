<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<?php $headerData = $this->foodies_headerlib->data(); ?>

<head>
    <title><?php echo $title . " | " . SITE_NAME; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php echo $headerData['meta_tags']; ?>
    <?php echo $headerData['favicon']; ?>
    <?php echo $headerData['stylesheets']; ?>
    <?php echo $headerData['plugins']; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php if ($page == "Home") { ?>
        <!-- <link rel="stylesheet" href="<?php echo FRONT_URL ?>assets/foodies/css/home_style.css"> -->
    <?php } ?>
    <?php echo $headerData['top_javascripts']; ?>
    <script>
        var SITE_URL = '<?php echo FRONT_URL ?>';
        var FRONT_IMAGES_URL = '<?php echo FRONT_IMAGES_URL ?>';
    </script>
    <style>
        .manage-error .form-control,
        .manage-error .bootstrap-select button {
            border: 1px solid #fe0d0d !important;
        }


.HeaderSection .HeaderButtons .base-count {
            position: absolute;
            
            right:256px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #FF045A;
            font-size: 11px;
            color: #FFF;
            bottom: auto;
            top: 0px;
            float:left;
        
}

        .base-count {
            position: absolute;
            
            right:-10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #FF045A;
            font-size: 11px;
            color: #FFF;
            bottom: auto;
            top: -5px;
            float:right;
        }
  @media(max-width: 767px) {
.base-count {
    position: absolute;
    left: auto;
    right: 0px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #FF045A;
    font-size: 11px;
    color: #FFF;
    bottom: auto;
    top: -9px;
}
.HeaderSection .HeaderButtons  .base-count {
    position: absolute;
    left: 170px;
    right: 0;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #FF045A;
    font-size: 11px;
    color: #FFF;
    bottom: auto;
    top: -33px;
    float:left;
    z-index:1;
}
    

}



        .toggles .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            margin: 5px 0 0 20px;
        }

        .toggles .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggles .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .toggles .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .toggles input:checked+.slider {
            background-color: #FEDF7C;
        }

        .toggles input:focus+.slider {
            box-shadow: 0 0 1px #FEDF7C;
        }

        .toggles input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .toggles .slider.round {
            border-radius: 34px;
        }

        .toggles .slider.round:before {
            border-radius: 50%;
        }

        .toggles .form-group {
            display: flex;
            flex-direction: row !important;
            justify-content: space-between;
            align-items: center;
        }

        .toggles .form-group .toggle-title {
            font-size: 15px;
            font-weight: 500;
            color: #555555;
        }

        .toggles {
            margin: 20px 0;
        }

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

        /* LOAD MORE BUTTON STYLE END */
        .btn-active {
            font-size: 12px;
            font-weight: bold;
            background-color: #7EDABF;
            color: #fff;
            padding: 6px 22px;
            border-radius: 4px;
            border: 2px solid #7EDABF;
        }

        .btn-active:hover {
            border: 2px solid #7EDABF;
            background-color: #fff;
            color: #7EDABF;
        }

        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }
    </style>
</head>

<body>
    <?php if ($page == "Home") {
        $this->load->view('includes/home_header');
    } else {
        $this->load->view('includes/header');
    } ?>
    <?php $this->load->view($module); ?>
    <?php $this->load->view('includes/footer'); ?>

    <?php echo $headerData['javascript']; ?>
    <?php echo $headerData['javascript_plugins']; ?>
    <?php echo $headerData['bottom_javascripts']; ?>
    <!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=<?= GOOGLE_MAP_API_KEY ?>"></script> -->
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= GOOGLE_MAP_API_KEY ?>" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            getLocation();
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        }

        function showPosition(position) {
            var Latitude = position.coords.latitude;
            var Longitude = position.coords.longitude;

            $("#cust_latitude").val(Latitude);
            $("#cust_longitude").val(Longitude);
            GetAddress(Latitude, Longitude);
        }

        /* function GetAddress(Latitude,Longitude) {
            var lat = parseFloat(Latitude);
            var lng = parseFloat(Longitude);
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        // var address = (results[1].formatted_address.length > 25)?results[1].formatted_address.substr(0,25)+"...":results[1].formatted_address;
                        var address = results[1].formatted_address;
                        $("#foodieslocation").html(address);
                    }
                }
            });
        } */
        function GetAddress(Latitude, Longitude) {
            var lat = parseFloat(Latitude);
            var lng = parseFloat(Longitude);
            $.ajax({
                type: 'POST',
                url: SITE_URL + 'home/get_location',
                data: 'latitude=' + lat + '&longitude=' + lng,
                dataType: 'json',
                success: function(reponse) {
                    if (reponse) {
                        var address = reponse.location;
                        var city = reponse.city;

                        $("#text_locate_city").html(city.trim());
                        $("#locate_city").val(city.trim());

                        $("#foodieslocation").html(address.trim());

                        var page = '<?= isset($page) ? $page : "" ?>';
                        if (page == 'Search_kitchen' || page == 'Search') {
                            loadkitchendata();
                        }
                        if (page == 'Checkout') {
                            $("#delivery_address").val(address.trim());
                            $("#deliverylatitude").val(lat);
                            $("#deliverylongitude").val(lng);

                            // var lat_1 = $("#kitchen_latitude").val();
                            // var long_1 = $("#kitchen_longitude").val();

                            getDistance(address.trim(), '<?= isset($kitchendata) ? $kitchendata['address'] : '' ?>', 'distance', 1);

                        }
                    } else {
                        $("#foodieslocation").html('Not Available');
                        $("#delivery_address").val('Not Available');
                    }
                }
            });
        }
    </script>
</body>

</html>