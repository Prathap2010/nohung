<script>
    var totalkitchenrecords = '<?=$totalkitchenrecords?>';
    var PER_PAGE_KITCHEN = '<?=PER_PAGE_KITCHEN?>';
</script>
<?php if(isset($is_logged_in) && $is_logged_in == 1) { 
    if(!empty($order_deliver)) { ?>
        <div class="deliveryMainSection">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="deliveryInformation">
                            <h2>Your today's meal is<br class="removeBreakTag" /> on the way!</h2>
                            <h3>Track your order</h3>

                            <?php $meal = $order_deliver['meal']; 
                            if($order_deliver['ordertype'] == "package") { ?>
                                <h4><?=$meal['plan']?></h4>
                            <?php } else{ ?>
                                <h4>Trial Meal</h4>
                            <?php } ?>
                            
                            <h5><?=$order_deliver['kitchen_name']?></h5>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="33.959" height="33.959" viewBox="0 0 33.959 33.959"><path d="M30.335,6.5h1.049a.663.663,0,0,0,0-1.326H28.866a.663.663,0,0,0-.663.663V8.352a.663.663,0,1,0,1.326,0V7.622a15.654,15.654,0,1,1-12.549-6.3,15.89,15.89,0,0,1,1.91.115.663.663,0,0,0,.16-1.316A17.22,17.22,0,0,0,16.979,0,16.979,16.979,0,0,0,4.973,28.985,16.979,16.979,0,0,0,30.335,6.5Z"/><path d="M68.07,70.912a.668.668,0,0,0-.922.207,12.752,12.752,0,1,0,3.992-3.984.668.668,0,0,0,.712,1.13A11.422,11.422,0,1,1,69.859,86.01a11.494,11.494,0,0,1-1.582-14.177A.668.668,0,0,0,68.07,70.912Z" transform="translate(-60.955 -60.956)"/><path d="M376.817,247.626h.8a.648.648,0,1,0,0-1.3h-.8a.648.648,0,1,0,0,1.3Z" transform="translate(-351.198 -229.988)"/><path d="M103.835,246.654a.648.648,0,0,0,.648.648h.8a.648.648,0,1,0,0-1.3h-.8A.648.648,0,0,0,103.835,246.654Z" transform="translate(-96.942 -229.686)"/><path d="M247.626,105.282v-.8a.648.648,0,0,0-1.3,0v.8a.648.648,0,0,0,1.3,0Z" transform="translate(-229.988 -96.942)"/><path d="M246.006,376.817v.8a.648.648,0,1,0,1.3,0v-.8a.648.648,0,1,0-1.3,0Z" transform="translate(-229.686 -351.198)"/><path d="M190.079,156.906a.648.648,0,1,0-.916.917l2.2,2.2a2.233,2.233,0,1,0,3.937,0l4.432-4.432a.648.648,0,0,0-.917-.917l-4.432,4.432a2.228,2.228,0,0,0-2.1,0Zm4.185,4.165a.936.936,0,1,1-.936-.936A.937.937,0,0,1,194.263,161.071Z" transform="translate(-176.31 -144.159)"/><path d="M119.284,119.284a.648.648,0,1,0-.458.19A.651.651,0,0,0,119.284,119.284Z" transform="translate(-110.338 -110.338)"/><path d="M316.086,11.174a.648.648,0,1,0-.458-.19A.651.651,0,0,0,316.086,11.174Z" transform="translate(-294.511 -9.238)"/></svg>
                                <span>Arriving at <?=date("H:i A", strtotime($meal['delivery_fromtime']))?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php } } ?>

<div class="whatDoYouLikeSection">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6">
                <div class="foodSelections">
                    <h2>What would you like<br class="removeBreakTag" />to order</h2>
                    <ul>
                        <li>
                            <input type="radio" name="selectVariety" id="VegFooods" class="selectVariety inputHidden" value="0" />
                            <label for="VegFooods">
                              <span><img src="<?=FRONT_IMAGES_URL?>vegFood_icon.png" alt=""></span>Veg
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="selectVariety" id="NonVegFoods" class="selectVariety inputHidden" value="1" />
                            <label for="NonVegFoods">
                                <span><img src="<?= FRONT_IMAGES_URL?>NonVegFood_icon.png" alt=""></span>Non-Veg
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="selectVariety" id="VegNonVegFoods" class="selectVariety inputHidden" value="2"/>
                            <label for="VegNonVegFoods">
                                <span><img src="<?= FRONT_IMAGES_URL?>VegNonVegFood-icon.png" alt=""></span>Both
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chooseFoodSection">
                    <ul>
                        <li>
                            <input type="radio" name="mealtype" id="ChooseBreakfast" class="inputHidden" value="0"/>
                            <label for="ChooseBreakfast">
                              <span><img src="<?= FRONT_IMAGES_URL?>Breakfast_img.png" alt=""></span>Breakfast
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="mealtype" id="ChooseLunch" class="inputHidden" value="1"/>
                            <label for="ChooseLunch" class="text-center">
                              <span><img src="<?= FRONT_IMAGES_URL?>Lunch_img.png" alt=""></span>Lunch
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="mealtype" id="ChooseDinner" class="inputHidden" value="2"/>
                            <label for="ChooseDinner">
                              <span><img src="<?= FRONT_IMAGES_URL?>Dinner_img.png" alt=""></span>Dinner
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="kitchensaroundsections">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="kitchen_left_heading">
                    <h2><span id="countkitchen">0</span> Kitchens around you</h2>
                </div>
            </div>
            <div class="col-md-4">
                <!-- <div class="filter_right_btn" style="margin-top: 0;">
                    <button type="button">
                        <img src="<?= FRONT_IMAGES_URL?>close-btn.png" alt="">
                    </button>
                </div> -->
            </div>
        </div>
        <ul class="searchkitchensection">
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
                    <label for="cuisinetype">Cuisine</label>
                    <img src="<?= FRONT_IMAGES_URL?>12-chicken rice, singapore.svg" alt="">
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
                        <option value="1.0">1.0 </option>
                        <option value="2.0">2.0 </option>
                        <option value="3.0">3.0 </option>
                        <option value="4.0">4.0 </option>
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
        <img src="<?= FRONT_IMAGES_URL?>playStor_bg.png" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="playStorContents">
                    <h2>Download NoHung app and start ordering today.</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <div class="playStorButton">
                        <div class="PlayStorIcon">
                            <a href=""><img src="<?=FRONT_IMAGES_URL?>GooglePlay.png" alt=""></a>
                            <a href=""><img src="<?=FRONT_IMAGES_URL?>AppStore.png" alt=""></a>
                        </div>
                        <a href=""><img src="<?=FRONT_IMAGES_URL?>QR_code.png" alt=""></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="NoHungerMobile">
                    <img src="<?=FRONT_IMAGES_URL?>NoHunger_mobile_icon.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>