<?php if(!empty($order_history)){
    foreach($order_history as $order){ ?>
        <div class="col-lg-6 col-md-6">
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
                            <span><?=$order['orderid']?> <b><?=date('F dS, Y',strtotime($order['orderdate']))?></b></span>
                        </div>
                    </div>
                    <!-- <p>₹4,225</p> -->
                </div>
                <div class="orderBodyManagement">
                    <?php 
                        if($order['ordertype'] == "package"){
                            
                            if(($order['packagetype'] == "weekly" || $order['packagetype'] == "both") && $order['weekly_plan'] != ""){ 
                                $pkg_arr = explode(",", $order['weekly_plan']);
                                ?>
                                <div class="weeklyPlanFood">
                                    <span>Weekly Plan</span>
                                    <?php foreach($pkg_arr as $val){ ?>
                                        <div class="weeklyPlanbreakFast">
                                            <img src="<?php echo KITCHEN_IMAGES_URL ?>Breakfast_icons.svg" alt="">
                                            <h5><?=$val?></h5>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php }

                            if(($order['packagetype'] == "monthly" || $order['packagetype'] == "both") && $order['monthly_plan'] != ""){ 
                                $pkg_arr = explode(",", $order['monthly_plan']);
                                ?>
                                <div class="weeklyPlanFood">
                                    <span>Monthly Plan</span>
                                    <?php foreach($pkg_arr as $val){ ?>
                                        <div class="weeklyPlanbreakFast">
                                            <img src="<?php echo KITCHEN_IMAGES_URL ?>Breakfast_icons.svg" alt="">
                                            <h5><?=$val?></h5>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php }
                        }else if($order['ordertype'] == "trial"){ ?>
                            <div class="weeklyPlanFood">
                                <span>Trial Orders</span>
                                <div class="weeklyPlanbreakFast">
                                    <img src="<?php echo KITCHEN_IMAGES_URL ?>Breakfast_icons.svg" alt="">
                                    <h5><?=$order['trial_orders']?></h5>
                                </div>
                            </div>
                        <?php }
                    ?>
                </div>
                <div class="orderManagementFooter">
                    <div class="orderManagementAddress">
                        <img src="<?php echo KITCHEN_IMAGES_URL ?>location_icons.svg" alt="">
                        <p class="text-ellipsis"><?=$order['deliveryaddress']?></p>
                    </div>
                    <div class="orderManagementOptionButton">
                        <span>
                        <?php if($order['order_status'] == "0"){
                            echo "Pending";
                        }else if($order['order_status'] == "1"){
                            echo "Order in Preparation";
                        }else if($order['order_status'] == "2"){
                            echo "Rejected";
                        }else if($order['order_status'] == "3"){
                            echo "Ready to pick";
                        }else if($order['order_status'] == "4"){
                            echo "Assign to Rider";
                        }else if($order['order_status'] == "5"){
                            echo "Start Delivery";
                        }else if($order['order_status'] == "6"){
                            echo "Delivered";
                        }else if($order['order_status'] == "7"){
                            echo "Cancelled";
                        }    ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}else{ ?>
    <div class="col-lg-12 col-md-12">
        <div class="contentOrderManagement">
            <p style="color:#7e7f7f;">No any orders available.</p>
        </div>
    </div> 
<?php } ?>