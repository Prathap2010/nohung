<div class="trackDevliveriesSections">
    <h2>Active Deliveries</h2>
    <div class="devlieriesUserSection">
        <div class="row">
            <?php if(!empty($active_delivery_orders)) { ?>
                <div class="col-lg-4">
                    <div class="listOfUserDevlieries">
                        <?php foreach($active_delivery_orders as $order) { ?>
                            
                            <div class="userContents">
                                <div class="headerUserContents">
                                    <div class="userImages">
                                        <?php if($order['customerimage']!="" && file_exists(USER_PROFILE_PATH.$order['customerimage'])) {
                                            $src = USER_PROFILE.$order['customerimage'];
                                        }else{
                                            $src = NOPROFILEIMAGE;
                                        }?>
                                        <img src="<?=$src?>" alt="">
                                        <div class="userNameSections">
                                            <h4><?=$order['customer_name']?></h4>
                                            <span><?=$order['orderid']?> <b><?=date('F dS, Y',strtotime($order['delivery_date']))?></b></span>
                                        </div>
                                    </div>
                                    <a href="tel:+91<?=$order['customer_mobileno']?>"><img src="<?=KITCHEN_IMAGES_URL?>callingButton.svg" alt=""></a>
                                </div>
                                <div class="userLocations">
                                    <img src="<?= KITCHEN_IMAGES_URL?>location_icons.svg" alt="">
                                    <p id="deliveryaddress<?=$order['orderitemsid']?>"><?=$order['deliveryaddress']?></p>
                                    <button class="btntrack" id="<?=$order['orderitemsid']?>"><img src="<?= KITCHEN_IMAGES_URL?>arrow.png" alt=""></button>

                                    <input type="hidden" id="rider_name<?=$order['orderitemsid']?>" value="<?=$order['rider_name']?>">
                                    <input type="hidden" id="rider_rating<?=$order['orderitemsid']?>" value="<?=$order['rider_rating']?>">
                                    <input type="hidden" id="rider_mobileno<?=$order['orderitemsid']?>" value="<?=$order['rider_mobileno']?>">
                                    <input type="hidden" id="rider_latitude<?=$order['orderitemsid']?>" value="<?=$order['rider_latitude']?>">
                                    <input type="hidden" id="rider_longitude<?=$order['orderitemsid']?>" value="<?=$order['rider_longitude']?>">
                                    <input type="hidden" id="delivery_latitude<?=$order['orderitemsid']?>" value="<?=$order['deliverylatitude']?>">
                                    <input type="hidden" id="delivery_longitude<?=$order['orderitemsid']?>" value="<?=$order['deliverylongitude']?>">
                                </div>
                            </div>
                            
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="devlieriesMapSections" style="height: 600px;">
                        <div id="map-layer" style="width: 100%;height: 100%;"></div>
                        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d7445.004162937876!2d79.0703571241687!3d21.09254014385535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sI-213%2C%20AB%20Heights%2C%20Manish%20Nagar%2C%20Nagpur%20-%20440034!5e0!3m2!1sen!2sin!4v1618684322586!5m2!1sen!2sin"
                            style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
                        
                        <div class="userInformOnMap" style="display:none">
                            <div class="mapAddressSection">
                                <div class="mapAddressContent">
                                    <p id="deliveryaddress"></p>
                                    <!-- <span>Manish Nagar, Nagpur - 440034</span> -->
                                </div>
                                <a href="javascript:void(0)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5">
                                        <defs>
                                            <style>
                                                .a {
                                                    fill: #fff;
                                                }
                                            </style>
                                        </defs>
                                        <path class="a"
                                            d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z"
                                            transform="translate(0 -132)"></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="mapUserInfo">
                                <div class="userInfoMap">
                                    <img src="<?= KITCHEN_IMAGES_URL?>userImg.png" alt="">
                                    <div class="rationgOnMap">
                                        <h5 id="rider_name"></h5>
                                        <ul id="rider_rating"></ul>
                                    </div>
                                </div>
                                <div class="OnMapDevliery">
                                    <img src="<?= KITCHEN_IMAGES_URL?>ActiveDeliveries.svg" alt="">
                                    <a id="rider_mobileno" href=""><img src="<?= KITCHEN_IMAGES_URL?>callingButton.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="col-lg-12">
                    <div class="listOfUserDevlieries">
                        No any active deliveries available.
                    </div>        
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY; ?>&callback=initMap">
    </script>
<script>
  	var map;
    var waypoints;
    function initMap() {
        // var mapLayer = document.getElementById("map-layer"); 
        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();
        var kitchen = new google.maps.LatLng('<?=$kitchendata['latitude']?>', '<?=$kitchendata['longitude']?>');
        var mapOptions = {
            zoom:8,
            center: kitchen
        }
        var map = new google.maps.Map(document.getElementById('map-layer'), mapOptions);
        directionsRenderer.setMap(map);

        $(".btntrack").on("click",function() {
            var id = $(this).attr("id");

            setAddressOnMap(id);
            
            var start = new google.maps.LatLng($("#rider_latitude"+id).val(), $("#rider_longitude"+id).val());
            var end = new google.maps.LatLng($("#delivery_latitude"+id).val(), $("#delivery_longitude"+id).val());

            drawPath(directionsService, directionsRenderer,start,end);

        });
        
    }

    function drawPath(directionsService, directionsRenderer,start,end) {
            directionsService.route({
              origin: start,
              destination: end,
              optimizeWaypoints: true,
              travelMode: 'DRIVING'
            }, function(response, status) {
                console.log(response);
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                } else {
                    window.alert('Problem in showing direction due to ' + status);
                }
            });
    }
    function setAddressOnMap(id){
        var deliveryaddress = $("#deliveryaddress"+id).html();
        var rider_name = $("#rider_name"+id).val();
        var rider_rating = $("#rider_rating"+id).val();
        var rider_mobileno = $("#rider_mobileno"+id).val();

        $("#deliveryaddress").html(deliveryaddress);
        $("#rider_name").html(rider_name);


        var html = "<li>"+rider_rating+"</li>";
        for(var i=1; i <= parseInt(rider_rating); i++){
            html += '<li><i class="fa fa-star"></i></li>';
        }

        $("#rider_rating").html(html);
        $("#rider_mobileno").attr("href","tel:+91"+rider_mobileno);
        
        $(".userInformOnMap").show();
    }

</script>