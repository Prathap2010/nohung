<script>
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

<script>
    

function search_kitchen(event) { 
  alert("Hmmm... You Must Enter Your favorite Kitchen Or Food");
}

    
</script>
<div class="mainSection">
    <div class="mainLeftsideImage">
        <img src="<?php echo FRONT_IMAGES_URL ?>mainLeftSide_img.png" alt="mainLeftSide_img">
    </div>
    <div class="mainTextContent">
        <h1>Worrying about daily meals? Discover kitchens around you.</h1>
        <div class="locateMeSection">
            <div class="locateMe_icon">
                <img class="fa-spin" src="<?php echo FRONT_IMAGES_URL ?>target.svg" alt="target">
                <span id="text_locate_city">Locate Me</span>
                <input type="hidden" name="locate_city" id="locate_city">
            </div>
            <div class="SearchLocation">
                <input type="text" id="search_kitchen" placeholder="Search for Kitchens, Meals, etc">
            </div>
            <a href="javascript:void(0)" onclick="search_kitchen(event)">Search</a>
        </div>
    </div>
    <div class="topFoodName">
        <ul>
            <li>
               <a href="<?= FRONT_URL ?>search-kitchen?mealtpye=breakfast"> <img src="<?php echo FRONT_IMAGES_URL ?>breakfast1.jpg" alt="breakfast_img">
                <div class="NameOfFood">
                    <span>Breakfast</span>
                    <a href="<?= FRONT_URL ?>search-kitchen?mealtpye=breakfast"><!--<img src="<?php echo FRONT_IMAGES_URL ?>arrow.svg" alt="arrow">--></a>
                </div>
                </a>
            </li>
            <li>
                <a href="<?= FRONT_URL ?>search-kitchen?mealtpye=lunch"> <img src="<?php echo FRONT_IMAGES_URL ?>vegmeal.jpg" alt="Lunch_img">
                <div class="NameOfFood">
                    <span>Lunch</span>
                    <a href="<?= FRONT_URL ?>search-kitchen?mealtpye=lunch"><!--<img src="<?php echo FRONT_IMAGES_URL ?>arrow.svg" alt="arrow">--></a>
                </div>
                </a>
            </li>
            <li>
                <a href="<?= FRONT_URL ?>search-kitchen?mealtpye=dinner"><img src="<?php echo FRONT_IMAGES_URL ?>dinner.jpg" alt="Dinner_img">
                <div class="NameOfFood">
                    <span>Dinner</span></a>
                    <a href="<?= FRONT_URL ?>search-kitchen?mealtpye=dinner"><!--<img src="<?php echo FRONT_IMAGES_URL ?>arrow.svg" alt="arrow">--></a>
                </div>
            </li>
            <li>
                <a href="<?= FRONT_URL ?>search-kitchen"><img src="<?php echo FRONT_IMAGES_URL ?>dinner.jpg" alt="Dinner_img">
                <div class="NameOfFood">
                    <span>All</span></a>
                    <a href="<?= FRONT_URL ?>search-kitchen"><!--<img src="<?php echo FRONT_IMAGES_URL ?>arrow.svg" alt="arrow">--></a>
                </div>
            </li>
        </ul>
    </div>
    <div class="mainRightsideImage">
        <img src="<?php echo FRONT_IMAGES_URL ?>mainSectionRight_img.png" alt="mainSectionRight_img">
    </div>
</div>

<div class="whyChooseContent">
    <div class="whyChooseContent_overlay">
        <img src="<?php echo FRONT_IMAGES_URL ?>choose_right_img.png" alt="choose_right_img">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="chooseLeftText">
                    <h2>Why choose NoHung for your daily meals?</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="chooseRightContent">
                            <img src="<?php echo FRONT_IMAGES_URL ?>healthy-eating.svg" alt="healthy-eating">
                            <p>Customize or Cancel Your Meal</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="chooseRightContent secondboxContent">
                            <img src="<?php echo FRONT_IMAGES_URL ?>taste.svg" alt="taste">
                            <p>Take a Trial Before Subscription</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="chooseRightContent">
                            <img src="<?php echo FRONT_IMAGES_URL ?>food-delivery.svg" alt="food-delivery">
                            <p>Highly-Reliable Riders</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="chooseRightContent secondboxContent">
                            <img src="<?php echo FRONT_IMAGES_URL ?>FilledOutline.svg" alt="FilledOutline">
                            <p>Weekly or Monthly Subscription</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="paymentSystem">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="paymentCardBox">
                    <img src="<?php echo FRONT_IMAGES_URL ?>SearchMeals.svg" alt="SearchMeals">
                    <h3>Search Meals</h3>
                    <p>Search for your favorite kitchens or meals and select package that suits you</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="paymentCardBox">
                    <img src="<?php echo FRONT_IMAGES_URL ?>Make_Payment.svg" alt="Make_Payment">
                    <h3>Make Payment</h3>
                    <p>Fill in your delivery details and make payment only for one time</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="paymentCardBox">
                    <img src="<?php echo FRONT_IMAGES_URL ?>On_Time_Delivery.svg" alt="On_Time_Delivery">
                    <h3>On-Time Delivery</h3>
                    <p>Get your food everyday on-time while its still hot by our reliable riders</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="groundWorkSection">
    <div class="groundWork_overlay">
        <img src="<?php echo FRONT_IMAGES_URL ?>groundwork_LeftSide_img.png" alt="groundwork_LeftSide_img">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="groundworkImg">
                    <img src="<?php echo FRONT_IMAGES_URL ?>groundWork_img.png" alt="groundWork_img">
                </div>
            </div>
            <div class="col-md-6">
                <div class="groundworkTextContent">
                    <h2>The groundwork of all happiness is to avoid skipping the meals.</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="palyStorSection">
    <div class="palyStorSection_overlay">
        <img src="<?php echo FRONT_IMAGES_URL ?>playStor_bg.png" alt="playStor_bg">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="playStorContents">
                    <h2>Download NOHUNG app and start ordering today.</h2>
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
                    <div class="playStorButton">
                        <div class="PlayStorIcon">
                            <a href=""><img src="<?php echo FRONT_IMAGES_URL ?>GooglePlay.png" alt="GooglePlay"></a>
                            <a href=""><img src="<?php echo FRONT_IMAGES_URL ?>AppStore.png" alt="AppStore"></a>
                        </div>
                        <a href=""><img src="<?php echo FRONT_IMAGES_URL ?>QR_code.png" alt="QR_code" class="Qrcode"></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="NoHungerMobile">
                    <img src="<?php echo FRONT_IMAGES_URL ?>NoHunger_mobile_icon.png" alt="NoHunger_mobile_icon">
                </div>
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
                    <img src="<?= FRONT_IMAGES_URL ?>paymentsuccess.png" alt="paymentsuccess" class="img-fluid">
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