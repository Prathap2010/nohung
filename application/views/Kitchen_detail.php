<script>
    var PER_PAGE_MENU_ITEM = '10';
    var PER_PAGE_REVIEWS = '10';
    var is_loggedIn = '<?php if (empty($this->session->userdata(base_url() . 'FOODIESUSERID'))) {
                            echo 0;
                        } else {
                            echo 1;
                        } ?>';
</script>


            <script>
function myFunction() {
  alert("adding item in cart");
}
</script>



<style>
    .foodsectionsloadmorebtn {
        border-radius: 8px !important;
        font-size: 15px;
        padding: 20px;
    }

    .listOfFoodSection {
        width: 100%;
        position: relative;
        background-color: #FFFFFF;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%);
        margin-bottom: 30px;
    }

    .customizablemodal .customizable-content .btn-container {
        width: 80px;
    }

    .customizablemodal .customizable-content .mealcount {
        width: 30px;
    }

    /* .customizablemodal .customizable-content .right-part{
        flex-basis: unset;
    } */
</style>

<div class="kitchen-information">
    <div class="hero-area">
        <div class="main-img">
            <img src="<?= FRONT_IMAGES_URL ?>pagen015hero.png" alt="" class="img-fluid full-width">
        </div>
        <div class="hero-logo">
            <?php if ($kitchendata['profile_image'] != "" && file_exists(USER_PROFILE_PATH . $kitchendata['profile_image'])) { ?>
                <img src="<?= USER_PROFILE . $kitchendata['profile_image'] ?>" class="thumbwidth" style="width: 130px;height: 130px;border-radius: 50%;border: 3px solid #FFF;outline: 2px solid #000;">
            <?php } else { ?>
                <img src="<?= FRONT_IMAGES_URL ?>Layer2.png" alt="">
            <?php } ?>
        </div>

        <div class="photo-like">
            <span><img src="<?= FRONT_IMAGES_URL ?>copy.png" alt=""></span>
            <span class="white bold photo-num">6 photos</span>
            <?php if (!empty($this->session->userdata(base_url() . 'FOODIESUSERID'))) {
                if ($kitchendata['isfavoritekitchen'] == 1) { ?>
                    <a href="javascript:void(0)" id="favorite_kitchen" onclick="remove_favorute_kitchen()" title="Remove to Favourite">
                        <img src="<?= FRONT_IMAGES_URL ?>Grou9902.png" alt="">
                    </a>
                <?php } else { ?>
                    <a href="javascript:void(0)" id="favorite_kitchen" onclick="add_favorute_kitchen()" title="Add to Favourite">
                        <img src="<?= FRONT_IMAGES_URL ?>Grou45649902.png">
                    </a>
                <?php } ?>
            <?php } else { ?>
                <a href="<?= FRONT_URL ?>login" title="Add to Favourite" title="Add to Favourite">
                    <img src="<?= FRONT_IMAGES_URL ?>Grou45649902.png">
                </a>
            <?php } ?>
        </div>
    </div>

    <div class="container-fluid">
        <div class="kitchenNameRating">
            <div class="left-part col-md-6">
                <p class="heading"><?= $kitchendata['kitchenname'] ?></p>
                <input type="hidden" id="userid" value="<?= $kitchendata['id'] ?>">
                <p class="sub-heading"><?php
                                        $meal = "";
                                        if ($kitchendata['issouthindian'] > 0) {
                                            $meal .= "South Indian, ";
                                        }
                                        if ($kitchendata['isnorthindian'] > 0) {
                                            $meal .= "North Indian, ";
                                        }
                                        if ($kitchendata['isotherindian'] > 0) {
                                            $meal .= "Other Indian, ";
                                        }
                                        echo rtrim($meal, ', ');
                                        ?></p>
                <p class="location"><img src="<?= FRONT_IMAGES_URL ?>Component1311.png" alt=""><span class="loc-address"><?= $kitchendata['address'] . ", " . $kitchendata['city'] . " - " . $kitchendata['pincode'] ?></span></p>
                <p><span class="open-time"><img src="<?= FRONT_IMAGES_URL ?>clock(2).png" alt="" class=""><span class="time"><?= date("h:i A", strtotime($kitchendata['fromtime'])) ?> to <?= date("h:i A", strtotime($kitchendata['totime'])) ?> <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?= $kitchendata['opendays'] ?>)--> -</span>
                        <?php if (date("H:i:s") > $kitchendata['fromtime'] && date("H:i:s") < $kitchendata['totime']) {
                            echo '<span class="lightgreen opennow">Open Now</span>';
                        } else {
                            echo '<span class="lightgreen opennow">Closed</span>';
                        } ?></p>
            </div>
            <div class="right-part col-md-6">
                <p class="delivery-rating"><span class="rating bold"><?= $kitchendata['averagerating'] ?></span><span class="rate-img"><img src="<?= FRONT_IMAGES_URL ?>Favorite.png" alt="" class=""></span><span class="cementgray review">(<?= $kitchendata['totalreview'] ?>+)</span></p>
                <div class="clearfix"></div>
                <p class="text-right">
                    <a href="javascript:void(0)" class="allreview" data-toggle="modal" data-target="#exampleModal1" onclick="rat_offset = 0;get_reviews(<?= $kitchendata['id'] ?>)">All Ratings & Reviews</a>
                </p>
            </div>
        </div>

        <div class="select-meal-plan">
            <p class="main-heading">Select Meal Plan</p>
            <div class="select-plan-container">
                <div class="select-plan">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-weekly-tab" data-toggle="pill" href="#pills-weekly" role="tab" aria-controls="pills-weekly" aria-selected="true">Weekly</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-monthly-tab" data-toggle="pill" href="#pills-monthly" role="tab" aria-controls="pills-monthly" aria-selected="false">Monthly</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-trialmeal-tab" data-toggle="pill" href="#pills-trialmeal" role="tab" aria-controls="pills-trialmeal" aria-selected="false">Trial Meal</a>
                        </li>
                    </ul>
                </div>
                <div class="mealperweek">
                    <p class="text-right"><img src="<?= FRONT_IMAGES_URL ?>indian_food_Lunch.png" alt=""><span class="meal-week">6 meals/week</span></p>
                </div>
            </div>

            <?php if (!empty($offerdata)) { ?>
                <div class="discount-code-content d-inline-flex">
                    <?php foreach ($offerdata as $i => $offer) { ?>
                        <div class="discount-code mr-2">
                            <input type="hidden" name="couponcode" id="discount<?= ($i + 1) ?>" class="input-hidden" <?= ($i == 0 ? "checked" : "") ?> />
                            <label for="discount<?= ($i + 1) ?>">
                                <div class="img-container">
                                    <img src="<?= FRONT_IMAGES_URL ?>Component53.png" alt="">
                                </div>
                                <div class="headings">
                                    <p class="sub-heading bold">Use Code <?= $offer['offercode'] ?></p>
                                    <p class="heading bold"><?= $offer['discount'] . ($offer['discounttype'] == 0 ? "%" : "Rs"); ?> OFF</p>
                                    
                                </div>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="heading-container">
                <p class="bold">MENU</p>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-weekly" role="tabpanel" aria-labelledby="pills-weekly-tab">
                    <div class="menu-container">
                        <div class="menu-meal">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-weekly-breakfast-tab" data-toggle="pill" href="#pills-weekly-breakfast" role="tab" aria-controls="pills-weekly-breakfast" aria-selected="true">Breakfast</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-weekly-lunch-tab" data-toggle="pill" href="#pills-weekly-lunch" role="tab" aria-controls="pills-weekly-lunch" aria-selected="false">Lunch</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-weekly-dinner-tab" data-toggle="pill" href="#pills-weekly-dinner" role="tab" aria-controls="pills-weekly-dinner" aria-selected="false">Dinner</a>
                                </li>
                            </ul>
                        </div>
                        
                        
                        <div class="select-meal-type">
                            <ul>
                                <li>
                                    <input type="radio" name="weeklyitemtype" id="weeklyVegFooods" value="0" checked class="inputHidden" />
                                    <label for="weeklyVegFooods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>vegFood_icon.png" alt=""></span>Veg
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" name="weeklyitemtype" id="weeklyNonVegFoods" value="1" class="inputHidden" />
                                    <label for="weeklyNonVegFoods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>NonVegFood_icon.png" alt=""></span>Non-Veg
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" name="weeklyitemtype" id="weeklyVegNonVegFoods" value="2" class="inputHidden" />
                                    <label for="weeklyVegNonVegFoods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>VegNonVegFood-icon.png" alt=""></span>Both
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-weekly-breakfast" role="tabpanel" aria-labelledby="pills-weekly-breakfast-tab">
                            <div class="breakfast-monthly-container" id="breakfast-weekly-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="breakfast-weekly-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_weekly_package('breakfast')">Load More</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="tab-pane fade" id="pills-weekly-lunch" role="tabpanel" aria-labelledby="pills-weekly-lunch-tab">
                            <div class="breakfast-monthly-container" id="lunch-weekly-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="lunch-weekly-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_weekly_package('lunch')">Load More</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-weekly-dinner" role="tabpanel" aria-labelledby="pills-weekly-dinner-tab">
                            <div class="breakfast-monthly-container" id="dinner-weekly-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="dinner-weekly-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_weekly_package('dinner')">Load More</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="tab-pane fade" id="pills-monthly" role="tabpanel" aria-labelledby="pills-monthly-tab">
                    <div class="menu-container">
                        <div class="menu-meal">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-monthly-breakfast-tab" data-toggle="pill" href="#pills-monthly-breakfast" role="tab" aria-controls="pills-monthly-breakfast" aria-selected="true">Breakfast</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-monthly-lunch-tab" data-toggle="pill" href="#pills-monthly-lunch" role="tab" aria-controls="pills-monthly-lunch" aria-selected="false">Lunch</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-monthly-dinner-tab" data-toggle="pill" href="#pills-monthly-dinner" role="tab" aria-controls="pills-monthly-dinner" aria-selected="false">Dinner</a>
                                </li>
                            </ul>
                        </div>
                        <div class="select-meal-type">
                            <ul>
                                <li>
                                    <input type="radio" name="monthlyitemtype" id="monthlyVegFooods" value="0" checked class="inputHidden" />
                                    <label for="monthlyVegFooods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>vegFood_icon.png" alt=""></span>Veg
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" name="monthlyitemtype" id="monthlyNonVegFoods" value="1" class="inputHidden" />
                                    <label for="monthlyNonVegFoods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>NonVegFood_icon.png" alt=""></span>Non-Veg
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" name="monthlyitemtype" id="monthlyVegNonVegFoods" value="2" class="inputHidden" />
                                    <label for="monthlyVegNonVegFoods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>VegNonVegFood-icon.png" alt=""></span>Both
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-monthly-breakfast" role="tabpanel" aria-labelledby="pills-monthly-breakfast-tab">
                            <div class="breakfast-monthly-container" id="breakfast-monthly-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="breakfast-monthly-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_monthly_package('breakfast')">Load More</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="tab-pane fade" id="pills-monthly-lunch" role="tabpanel" aria-labelledby="pills-monthly-lunch-tab">
                            <div class="breakfast-monthly-container" id="lunch-monthly-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="lunch-monthly-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_monthly_package('lunch')">Load More</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-monthly-dinner" role="tabpanel" aria-labelledby="pills-monthly-dinner-tab">
                            <div class="breakfast-monthly-container" id="dinner-monthly-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="dinner-monthly-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_monthly_package('monthly')">Load More</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="pills-trialmeal" role="tabpanel" aria-labelledby="pills-trialmeal-tab">
                    <div class="menu-container">
                        <div class="menu-meal">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-trial-breakfast-tab" data-toggle="pill" href="#pills-trial-breakfast" role="tab" aria-controls="pills-trial-breakfast" aria-selected="true">Breakfast</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-trial-lunch-tab" data-toggle="pill" href="#pills-trial-lunch" role="tab" aria-controls="pills-trial-lunch" aria-selected="false">Lunch</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-trial-dinner-tab" data-toggle="pill" href="#pills-trial-dinner" role="tab" aria-controls="pills-trial-dinner" aria-selected="false">Dinner</a>
                                </li>
                            </ul>
                        </div>
                        <div class="select-meal-type">
                            <ul>
                                <li>
                                    <input type="radio" name="trialitemtype" id="trialVegFooods" value="0" checked class="inputHidden" />
                                    <label for="trialVegFooods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>vegFood_icon.png" alt=""></span>Veg
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" name="trialitemtype" id="trialNonVegFoods" value="1" class="inputHidden" />
                                    <label for="trialNonVegFoods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>NonVegFood_icon.png" alt=""></span>Non-Veg
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" name="trialitemtype" id="trialVegNonVegFoods" value="2" class="inputHidden" />
                                    <label for="trialVegNonVegFoods">
                                        <span><img src="<?= FRONT_IMAGES_URL ?>VegNonVegFood-icon.png" alt=""></span>Both
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-trial-breakfast" role="tabpanel" aria-labelledby="pills-trial-breakfast-tab">
                            <div class="breakfast-menu-container" id="breakfast-trial-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="breakfast-trial-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_trialmenu('breakfast')">Load More</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-trial-lunch" role="tabpanel" aria-labelledby="pills-trial-lunch-tab">
                            <div class="breakfast-menu-container" id="lunch-trial-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="lunch-trial-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_trialmenu('lunch')">Load More</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-trial-dinner" role="tabpanel" aria-labelledby="pills-trial-dinner-tab">
                            <div class="breakfast-menu-container" id="dinner-trial-meal">
                            </div>
                            <div class="foodsectionsloadmorebtn" id="dinner-trial-meal-lmbtn" style="display: none;">
                                <a href="javascript:void(0)" onclick="load_trialmenu('dinner')">Load More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
    
</div>

<!-- Rating And Review Modal --->
<div class="reviews-rating-modal modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="headings">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Reviews</h5>
                    <p class="sub-heading">All Reviews (<span id="mdl_reviews_count">0</span>)</p>
                </div>
                <div class="exapand-food-review-btn-container text-right">
                    <img src="<?= FRONT_IMAGES_URL ?>Group10153.png" alt="">
                </div>
                <div class="btn-close-container">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt=""></span>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <div class="customer-review-container">
                    <div class="customer-review-contents">
                        <div id="reviewlist"></div>
                        <div class="foodsectionsloadmorebtn" id="review-lmbtn" style="display: none;">
                            <a href="javascript:void(0)" onclick="get_reviews(<?= $kitchendata['id'] ?>)">Load More</a>
                        </div>
                    </div>
                    <div class="food-experience">
                        <div class="food-experience-container">
                            <form id="rating-form">
                                <p class="heading">Rate your food experience</p>
                                <input type="hidden" name="review_rating" id="review_rating">
                                <div class="rating">
                                    <ul id='stars'>
                                        <li class='star' title='Poor' data-value='1'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Fair' data-value='2'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Good' data-value='3'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Excellent' data-value='4'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='WOW!!!' data-value='5'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                    </ul>
                                </div>
                                <div class="review-desc-container">
                                    <p class="review-heading">With a Review</p>
                                    <textarea rows="5" id="review_message" name="review_message"></textarea>
                                </div>
                                <div class="food-status2">
                                    <div class="left-part">
                                        <p>Food Quality</p>
                                    </div>
                                    <div class="right-part">
                                        <input type="radio" id="foodqualitygood" name="radioQuality" value="1" checked>
                                        <label for="foodqualitygood"><img src="<?= FRONT_IMAGES_URL ?>like.png"></label>
                                        <input type="radio" id="foodqualitybad" name="radioQuality" value="0">
                                        <label for="foodqualitybad"><img src="<?= FRONT_IMAGES_URL ?>like1.png"></label>
                                    </div>
                                </div>
                                <div class="food-status2">
                                    <div class="left-part">
                                        <p>Taste</p>
                                    </div>
                                    <div class="right-part">
                                        <input type="radio" id="tastegood" name="radioTaste" value="1" checked>
                                        <label for="tastegood"><img src="<?= FRONT_IMAGES_URL ?>like.png"></label>
                                        <input type="radio" id="tastebad" name="radioTaste" value="0">
                                        <label for="tastebad"><img src="<?= FRONT_IMAGES_URL ?>like1.png"></label>
                                    </div>
                                </div>
                                <div class="food-status2">
                                    <div class="left-part">
                                        <p>Quantity</p>
                                    </div>
                                    <div class="right-part">
                                        <input type="radio" id="quantitygood" name="radioQuantity" value="1" checked>
                                        <label for="quantitygood"><img src="<?= FRONT_IMAGES_URL ?>like.png"></label>
                                        <input type="radio" id="quantitybad" name="radioQuantity" value="0">
                                        <label for="quantitybad"><img src="<?= FRONT_IMAGES_URL ?>like1.png"></label>
                                    </div>
                                </div>
                                <div class="foodexp-btn-container">
                                    <?php if (empty($this->session->userdata(base_url() . 'FOODIESUSERID'))) { ?>
                                        <a href="<?= FRONT_URL ?>login" class="foodexp-submit" name="foodexp-submit">Submit</a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)" onclick="submit_review()" class="foodexp-submit" name="foodexp-submit">Submit</a>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="food-review-img-container">
                        <img src="<?= FRONT_IMAGES_URL ?>Asset1.png" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="packageModal" class="packagemodal modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" id="packagetitle"></p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body" id="package_detail">
            </div>
        </div>
    </div>
</div>

<!-- Select This Package --->
<div id="select-package-modal" class="selectpackagemodal modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Package 1 - Select Date & Time</p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" id="datetimeerror" style="color: red;"></div>
                <div class="datetimecontainer">
                    <div class="date-section">
                        <p class="heading">When would you like to start meal? Select a week</p>
                        <div id="weekpicker"></div>
                    </div>
                    <div class="time-section">
                        <p class="heading">At what time you want delivery?</p>
                        <div class="choose-time">
                            <input type="radio" name="delivery-time" id="fulleleven" value="11:00-11:30"><label for="fulleleven">11:00-11:30</label>
                            <input type="radio" name="delivery-time" id="halfeleven" value="11:30-12:00"><label for="halfeleven">11:30-12:00</label>
                            <input type="radio" name="delivery-time" id="halftwelve" value="12:30-13:00"><label for="halftwelve">12:30-1:00</label>
                            <input type="radio" name="delivery-time" id="halfone" value="13:30-14:00"><label for="halfone">1:30-2:00</label>
                            <input type="radio" name="delivery-time" id="fulltwo" value="14:00-14:30"><label for="fulltwo">2:00-2:30</label>
                            <input type="radio" name="delivery-time" id="halftwo" value="14:30-15:00"><label for="halftwo">2:30-3:00</label>
                        </div>
                    </div>
                </div>
                <div class="includesunsat">
                    <div class="left-part-section">
                        <!-- <div class="weekendwith">
                    <div class="radio radio-success">
                        <input type="radio" name="includeweekend" id="includeSat" checked><label for="includeSat">Include Saturday</label>
                    </div>  
                    <div class="radio radio-success">
                        <input type="radio" name="includeweekend" id="includeSun"><label for="includeSun">Include Sunday</label>
                    </div>  
               </div> -->
                        <!-- <div class="form-row toggles">
                    <div class="form-group" style="margin-left: 20px;">
                        <div class="toggle-title">Including Saturday</div>
                        <label class="switch">
                            <input type="checkbox" id="including_saturday" name="including_saturday" value="1" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                
                    <div class="form-group" style="margin-left: 20px;">
                        <div class="toggle-title">Including Sunday</div>
                        <label class="switch">
                            <input type="checkbox" id="including_sunday" name="including_sunday" value="1" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div> -->
                    </div>
                    <div class="right-part-section">
                        <div class="btn-container">
                            <a href="javascript:void(0)" class="btn-back" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>right-arrow.png" alt="" class="img-fluid"><span>Back</span></a>
                            <a href="javascript:void(0)" onclick="check_date()" class="btn-next"><span>Next</span> <img src="<?= FRONT_IMAGES_URL ?>right-arrow.png" alt="" class="img-fluid"></a> <!-- data-toggle="modal" data-target="#packageconfirm" -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


<!-- #customizable-modal  --->
<div id="customizable-modal" class="customizablemodal modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Select from below options</p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body">
                <div class="customizable-modal-container">
                    <div id="customizable_modal_data">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #packageconfirm  --->
<div id="packageconfirm" class="packageconfirmmodal modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Package 1</p>
                <button type="button" class="close" data-dismiss="modal"><img src="<?= FRONT_IMAGES_URL ?>Group3314.png" alt="" class="img-fluid"></button>
            </div>
            <div class="modal-body">
                <form id="package_form">
                    <input type="hidden" name="ord_kitchenid" id="ord_kitchenid" value="<?= $kitchendata['id'] ?>">
                    <input type="hidden" name="ord_mealplan" id="ord_mealplan">
                    <input type="hidden" name="ord_packageid" id="ord_packageid">

                    <input type="hidden" name="ord_delivery_startdate" id="ord_delivery_startdate">
                    <input type="hidden" name="ord_delivery_enddate" id="ord_delivery_enddate">
                    <input type="hidden" name="ord_delivery_fromtime" id="ord_delivery_fromtime">
                    <input type="hidden" name="ord_delivery_totime" id="ord_delivery_totime">

                    <div id="package_confirm_detail">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>