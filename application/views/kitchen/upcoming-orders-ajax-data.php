<?php if(!empty($upcoming_orders)){
    foreach($upcoming_orders as $order){ ?>
        <div class="col-lg-4 col-md-6">
            <div class="contentOrderManagement">
                <div class="OrderManagementHeader">
                    <div class="orderImages">
                        <?php if($order['customerimage']!="" && file_exists(USER_PROFILE_PATH.$order['customerimage'])) {
                            $src = USER_PROFILE.$order['customerimage'];
                        }else{
                            $src = NOPROFILEIMAGE;
                        }?>
                        <img src="<?php echo $src; ?>" alt="Customer">
                        <div class="userNameOrdermanagement">
                            <h4><?=$order['customer_name']?></h4>
                            <span><?=$order['orderid']?> <b><?=date('F dS, Y',strtotime($order['delivery_date']))?></b></span>
                        </div>
                    </div>
                    <a href="tel:+91<?=$order['customer_mobileno']?>"><img src="<?= KITCHEN_IMAGES_URL?>callingButton.svg" alt=""></a>
                </div>
                <div class="orderBodyManagement">
                    <div class="weeklyPlanFood">
                        <?php if($order['mealfor'] == "0"){
                            $meal = "Breakfast";
                        }else if($order['mealfor'] == "1"){
                            $meal = "Lunch";
                        }else if($order['mealfor'] == "2"){
                            $meal = "Dinner";
                        }else if($order['mealfor'] == ""){
                            $meal = "Trial";
                        } ?>
                        <span>Menu For <?=$meal?></span>
                        <div class="weeklyPlanbreakFast">
                            <img src="<?= KITCHEN_IMAGES_URL?>indian_food_Lunch.svg" alt="">
                            <h5><?=$order['item_name']?></h5>
                        </div>
                    </div>
                </div>
                <div class="orderManagementFooter">
                    <div class="orderManagementAddress">
                        <img src="<?= KITCHEN_IMAGES_URL?>location_icons.svg" alt="">
                        <p class="text-ellipsis"><?=$order['deliveryaddress']?></p>
                        <a href="javascript:void(0)"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5"><defs><style>.a{fill:#fff;}</style></defs><path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path></svg></a>
                    </div>
                </div>
            </div>
        </div>
<?php }
}else{ ?>
    <div class="col-lg-12 col-md-12">
        <div class="contentOrderManagement">
            <p style="color:#7e7f7f;">No any upcoming orders available.</p>
        </div>
    </div> 
<?php } ?>