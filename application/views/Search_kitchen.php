<script>
    var totalkitchenrecords = '<?= $totalkitchenrecords ?>';
    var PER_PAGE_KITCHEN = '<?= PER_PAGE_KITCHEN ?>';
    var is_payment_success = '<?php if (isset($is_payment_success)) {
                                    echo 1;
                                } else {
                                    echo 0;
                                } ?>';
    var is_payment_failed = '<?php if (isset($is_payment_failed)) {
                                    echo 1;
                                } else {
                                    echo 0;
                                } ?>';
</script>
<section class="hero-area10">
    <!--<div class="image-container">-->
    <!--    <img src="<?= FRONT_IMAGES_URL ?>Group9978.png" alt="" class="img-fluid full-width">-->
    <!--</div>-->
</section>

<?php if (isset($is_logged_in) && $is_logged_in == 1) {
    if (!empty($todays_order)) { ?>
        <section class="hero-area11">
            <div class="image-container">
                <img src="<?= FRONT_IMAGES_URL ?>Group10189.png" alt="" class="img-fluid full-width">
            </div>
            <div class="today-order">
                <div class="today-order-header">
                    <h4>TODAY'S ORDER</h4>
                    <div class="img-container">
                        <a href="#"><img src="<?= FRONT_IMAGES_URL ?>callingButton.png" alt="" class="img-fluid callingButton"></a>
                    </div>
                </div>
                <div class="meal-type-section">
                    <?php
                    foreach ($todays_order['meal'] as $meal) {
                        if ($todays_order['ordertype'] == "package") { ?>
                            <div class="meal-type-container">
                                <p class="meal-type cementgray">Meal Type</p>
                                <p><img src="<?= FRONT_IMAGES_URL ?>Breakfast_icons.png" alt=""><span class="meal-select"><?= $meal['plan'] ?></span></p>
                                <div class="menu-customize">
                                    <p class="menufor cementgray">Menu for <?= $meal['plan'] ?></p>

                                </div>
                                <div class="meal-type-time">
                                    <p class="meal-heading"><?= $meal['item_name'] ?></p>
                                    <p class="meal-time foodiyellow"><?= date("H:i A", strtotime($meal['delivery_fromtime'])) ?></p>
                                </div>
                                <?php if ($meal['iscancel'] == 1) { ?>
                                    <div id="order_<?= $todays_order['orderitemsid'] ?>">
                                        <p class="cancel-customize-heading cementgray">Time to cancel</p>
                                        <p class="order-time" id="cancel_time_<?= $todays_order['orderitemsid'] ?>">
                                            <input type="hidden" id="cancel_datetime_<?= $todays_order['orderitemsid'] ?>" value="<?= $meal['cancel_datetime']; ?>">
                                            <?php
                                            $chars = str_split($meal['cancel_time']);

                                            foreach ($chars as $char) { ?>
                                                <span><?= $char ?></span>
                                            <?php }
                                            ?>
                                        </p>
                                        <p class="text-right"><a href="javascript:void(0)" onclick="cancel_meal('<?= $todays_order['orderitemsid'] ?>')">Cancel Meal</a></p>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="meal-type-container">
                                <p class="meal-type cementgray">Meal Type</p>
                                <p><img src="<?= FRONT_IMAGES_URL ?>Breakfast_icons.png" alt=""><span class="meal-select">Trial</span></p>
                                <div class="menu-customize">
                                    <p class="menufor cementgray">Menu for Trial Meal</p>

                                </div>
                                <div class="meal-type-time">
                                    <p class="meal-heading"><?= $meal['item_name'] ?></p>
                                    <p class="meal-time foodiyellow"><?= date("H:i A", strtotime($meal['delivery_fromtime'])) ?></p>
                                </div>
                            </div>
                    <?php }
                    } ?>

                    <!-- <div class="meal-type-container">
                        <p class="meal-type cementgray">Meal Type</p>
                        <p><img src="<?= FRONT_IMAGES_URL ?>indian_food_Lunch.png" alt=""><span class="meal-select">Lunch</span></p>
                        <div class="menu-customize">
                            <p class="menufor cementgray">Menu for Breakfast</p>
                            
                        </div>
                        <div class="meal-type-time">
                            <p class="meal-heading">Paneer Sabji + Roti + Dal + Rice + Salad</p>
                            <p class="meal-time foodiyellow">01:30 PM</p>
                        </div>
                        <p class="cancel-customize-heading cementgray">Time to customize or cancel</p>
                        <p class="order-time">
                            <span>0</span>
                            <span>5</span>
                            <span>:</span>
                            <span>0</span>
                            <span>0</span>
                            <span>:</span>
                            <span>4</span>
                            <span>5</span>
                        </p>
                        <p class="text-right"><a href="#">Cancel Meal</a></p>
                    </div> -->
                </div>
            </div>
            <div class="main-heading">
                <p>Your today's orders are being prepared!</p>
            </div>
            <div class="contact-kitchen-rider">
                <?php if ($todays_order['kitchen_mobileno'] != "") { ?>
                    <div class="contact">
                        <p class="contact-name">Contact Kitchen</p>
                        <p class="contact-mobile bold">+91 <?= $todays_order['kitchen_mobileno'] ?></p>
                    </div>
                <?php } ?>
                <?php if ($todays_order['rider_mobileno'] != "") { ?>
                    <div class="contact">
                        <p class="contact-name">Contact Rider</p>
                        <p class="contact-mobile bold">+91 <?= $todays_order['rider_mobileno'] ?></p>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php }
    if (!empty($order_deliver)) { ?>
        <section class="hero-area13">
            <div class="image-container">
                <img src="<?= FRONT_IMAGES_URL ?>Grp10189.png" alt="" class="img-fluid full-width">
            </div>
            <div class="order-summery">
                <div class="order-summery-header">
                    <h4>ORDER SUMMARY</h4>
                    <div class="img-container">
                        <a href="#"><img src="<?= FRONT_IMAGES_URL ?>callingButton.png" alt="" class="img-fluid callingButton"></a>
                    </div>
                </div>
                <div class="meal-type-section">
                    <?php
                    $meal = $order_deliver['meal'];
                    if ($order_deliver['ordertype'] == "package") { ?>
                        <div class="meal-type-container borderbottom0">
                            <p class="meal-type cementgray">Meal Type</p>
                            <p><img src="<?= FRONT_IMAGES_URL ?>indian_food_Lunch.png" alt=""><span class="meal-select"><?= $meal['plan'] ?></span></p>
                            <div class="menu-customize">
                                <p class="menufor cementgray">Menu for <?= $meal['plan'] ?></p>
                                <!-- <p><a href="#">Customised</a></p> -->
                            </div>
                            <div class="meal-type-heading">
                                <p class="meal-heading full-width"><?= $meal['item_name'] ?></p>
                            </div>
                            <p class="deliveryby cementgray margin-bottom0">Delivery by</p>
                            <div class="deliveryboy-rating">
                                <p class="deliveryboy"><?= $order_deliver['rider_name'] ?></p>
                                <p class="delivery-rating"><span class="rating bold"><?= $order_deliver['rider_rating'] ?></span><span class="rate-img"><img src="<?= FRONT_IMAGES_URL ?>Favorite.png" alt="" class=""></span><span class="review">(<?= $order_deliver['rider_review'] ?>)</span></p>
                            </div>
                            <p class="arrive-time foodiyellow">
                                <span><img src="<?= FRONT_IMAGES_URL ?>hourglass.png" alt=""></span>
                                <span class="bold">Arriving at <?= date("H:i A", strtotime($meal['delivery_fromtime'])) ?></span>
                            </p>
                            <a href="javascript:void(0)" class="btn-track-order" onclick="track_order('<?= $order_deliver['track_rider_latitude'] ?>','<?= $order_deliver['track_rider_longitude'] ?>')">Track your order</a>
                        </div>
                    <?php } else { ?>
                        <div class="meal-type-container borderbottom0">
                            <p class="meal-type cementgray">Meal Type</p>
                            <p><img src="<?= FRONT_IMAGES_URL ?>indian_food_Lunch.png" alt=""><span class="meal-select">Trial</span></p>
                            <div class="menu-customize">
                                <p class="menufor cementgray">Menu for Trial Meal</p>
                            </div>
                            <div class="meal-type-heading">
                                <p class="meal-heading full-width"><?= $meal['item_name'] ?></p>
                            </div>
                            <p class="deliveryby cementgray margin-bottom0">Delivery by</p>
                            <div class="deliveryboy-rating">
                                <p class="deliveryboy"><?= $order_deliver['rider_name'] ?></p>
                                <p class="delivery-rating"><span class="rating bold"><?= $order_deliver['rider_rating'] ?></span><span class="rate-img"><img src="<?= FRONT_IMAGES_URL ?>Favorite.png" alt="" class=""></span><span class="review">(<?= $order_deliver['rider_review'] ?>)</span></p>
                            </div>
                            <p class="arrive-time foodiyellow">
                                <span><img src="<?= FRONT_IMAGES_URL ?>hourglass.png" alt=""></span>
                                <span class="bold">Arriving at <?= date("H:i A", strtotime($meal['delivery_fromtime'])) ?></span>
                            </p>
                            <a href="javascript:void(0)" class="btn-track-order" onclick="track_order('<?= $order_deliver['track_rider_latitude'] ?>','<?= $order_deliver['track_rider_longitude'] ?>')">Track your order</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="main-heading">
                <p>Your today's lunch is on the way!</p>
            </div>
            <div class="contact-kitchen-rider">
                <?php if ($order_deliver['kitchen_mobileno'] != "") { ?>
                    <div class="contact">
                        <p class="contact-name">Contact Kitchen</p>
                        <p class="contact-mobile bold">+91 <?= $order_deliver['kitchen_mobileno'] ?></p>
                    </div>
                <?php } ?>
                <?php if ($order_deliver['rider_mobileno'] != "") { ?>
                    <div class="contact">
                        <p class="contact-name">Contact Rider</p>
                        <p class="contact-mobile bold">+91 <?= $order_deliver['rider_mobileno'] ?></p>
                    </div>
                <?php } ?>
            </div>
        </section>
<?php }
} ?>

<div class="liketoday">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="foodSelections">
                    <h2>Hi there, what would you like to have today?</h2>
                    <ul>
                        <li>
                            <input type="radio" name="selectVariety" id="VegFooods" class="inputHidden" value="0" />
                            <label for="VegFooods">
                                <span><img src="<?= FRONT_IMAGES_URL ?>vegFood_icon.png" alt=""></span>Veg
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="selectVariety" id="NonVegFoods" class="inputHidden" value="1" />
                            <label for="NonVegFoods">
                                <span><img src="<?= FRONT_IMAGES_URL ?>NonVegFood_icon.png" alt=""></span>Non-Veg
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="selectVariety" id="VegNonVegFoods" class="inputHidden" value="2" checked />
                            <label for="VegNonVegFoods">
                                <span><img src="<?= FRONT_IMAGES_URL ?>VegNonVegFood-icon.png" alt=""></span>Both
                            </label>
                        </li>
                        <!-- <li class="display-meal-filters">
                            <img src="<?= FRONT_IMAGES_URL ?>Group10153.png" alt="">
                        </li> -->
                    </ul>
                    <div class="clearfix"></div>
                    <p class="cementgray"><span class="foodiyellow bold" id="countkitchen">00</span> Kitchens around you</p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="kitchensaroundsections homekitchensection">
    <div class="container-fluid">
        <ul>
            <li>
                <div class="kitchenscuisine">
                    <label for="mealtype">Meal Type</label>
                    <select name="mealtype" id="mealtype">
                        <option value="">All</option>
                        <option value="0" <?= (isset($_GET['mealtpye']) && $_GET['mealtpye'] == "breakfast" ? "selected" : "") ?>>Breakfast</option>
                        <option value="1" <?= (isset($_GET['mealtpye']) && $_GET['mealtpye'] == "lunch" ? "selected" : "") ?>>Lunch</option>
                        <option value="2" <?= (isset($_GET['mealtpye']) && $_GET['mealtpye'] == "dinner" ? "selected" : "") ?>>Dinner</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="kitchenscuisine">
                    <label for="cuisinetype">Cuisine</label>
                    <img src="<?= FRONT_IMAGES_URL ?>12-chicken rice, singapore.svg" alt="">
                    <select name="cuisinetype" id="cuisinetype" class="Cuisineselectbox">
                        <option value="">All</option>
                        <option value="0">South Indian Meals</option>
                        <option value="1">North Indian Meals</option>
                        <option value="2">Other Indian Meals</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="kitchenscuisine">
                    <label for="mealplan">Meal Plan</label>
                    <select name="mealplan" id="mealplan">
                        <option value="">All</option>
                        <option value="0">Weekly</option>
                        <option value="1">Monthly</option>
                        <option value="2">Trial Meal</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="kitchenscuisine">
                    <label for="price">Price</label>
                    <select name="price" id="price">
                        <option value="">All</option>
                        <option value="0-100">₹0-₹100</option>
                        <option value="101-500">₹101-₹500</option>
                        <option value="501-1000">₹501-₹1000</option>
                        <option value="1001-1500">₹1001-₹1500</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="kitchenscuisine">
                    <label for="rating">Rating</label>
                    <img src="<?= FRONT_IMAGES_URL ?>Favorite.png" alt="" class="rating-top-img">
                    <select name="rating" id="rating">
                        <option value="">All</option>
                        <option value="1.0">1</option>
                        <option value="2.0">2</option>
                        <option value="3.0">3</option>
                        <option value="4.0">4</option>
                    </select>
                </div>
            </li>

        </ul>
    </div>
</div>



<div class="foodsections">
    <div class="container-fluid">
        <div class="row" id="kitchenlist">

        </div>
        <div class="foodsectionsloadmorebtn" style="display:none;">
            <a href="javascript:void(0)" onclick="loadkitchendata()">load more</a>
        </div>
    </div>
</div>

<div class="palyStorSection">
    <div class="palyStorSection_overlay">
        <img src="<?= FRONT_IMAGES_URL ?>playStor_bg.png" alt="" class="img-fluid">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="playStorContents">
                    <h2>Download NoHung app and start ordering today.</h2>
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
                    <div class="playStorButton">
                        <div class="PlayStorIcon">
                            <a href=""><img src="<?= FRONT_IMAGES_URL ?>GooglePlay.png" alt="" class="img-fluid"></a>
                            <a href=""><img src="<?= FRONT_IMAGES_URL ?>AppStore.png" alt="" class="img-fluid"></a>
                        </div>
                        <a href=""><img src="<?= FRONT_IMAGES_URL ?>QR_code.png" alt="" class="img-fluid Qrcode"></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="NoHungerMobile">
                    <img src="<?= FRONT_IMAGES_URL ?>NoHunger_mobile_icon.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>


<div id="trackorderModal" class="trackordermodal modal fade" role="dialog">
    <div class="modal-dialog" style="max-width: 900px;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Track Order</p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL  ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body" style="height:500px">
                <div id="track_map" style="width: 100%;height: 100%;"></div>
            </div>
        </div>
    </div>
</div>
<!-- Add Payment Dialog Box --->
<div id="checkout-modal" class="checkout-modal modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body">
                <div class="img-container">
                    <img src="<?= FRONT_IMAGES_URL  ?>paymentsuccess.png" alt="paymentsuccess" class="img-fluid">
                </div>
                <p class="heading" id="title_payment_status">Payment Completed Successfully!</p>
                <div class="btn-container">
                    <!--<a href="#" data-dismiss="modal" class="btn-booking-confirm">Booking Confirmed</a>--->
                    <a href="<?= FRONT_URL ?>" class="btn-booking-confirm">Home</a>
                </div>

            </div>

        </div>

    </div>
</div>
<!-- <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY; ?>">
</script> -->

<script>
    function track_order(lat, long) {

        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();
        var rider_location = new google.maps.LatLng(lat, long);
        var mapOptions = {
            zoom: 18,
            center: rider_location
        }
        var infoWindow = new google.maps.InfoWindow;

        var map = new google.maps.Map(document.getElementById('track_map'), mapOptions);
        directionsRenderer.setMap(map);

        var marker = new google.maps.Marker({
            position: rider_location,
            map: map,
            title: '',
        });

        $("#trackorderModal").modal("show");
    }
</script>