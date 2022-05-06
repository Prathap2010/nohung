<?php if(count($order_requests) > 0){ ?>
    <?php foreach($order_requests as $order){?>
        <div class="col-lg-4 col-md-6" id="orderbox<?=$order['id']?>">
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
                    <p>₹<?=number_format($order['netamount'],2,'.',',')?></p>
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
                    <!-- <div class="weeklyPlanFood">
                        <span>Monthly Plan</span>
                        <div class="weeklyPlanbreakFast">
                            <img src="<?php echo KITCHEN_IMAGES_URL ?>indian_food_Lunch.svg" alt="">
                            <h5>Lunch</h5>
                        </div>
                    </div> -->
                </div>
                <div class="orderManagementFooter">
                    <div class="orderManagementAddress">
                        <img src="<?php echo KITCHEN_IMAGES_URL ?>location_icons.svg" alt="">
                        <p class="text-ellipsis"><?=$order['deliveryaddress']?></p>
                    </div>
                    <div class="orderManagementOptionButton">
                        <a class="rightCheckButton" href="javascript:void(0)" onclick="changeorderstatus(<?=$order['id']?>,1)" title="Accept"><svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                        <a class="closedMarkButton" href="javascript:void(0)" onclick="changeorderstatus(<?=$order['id']?>,2)" title="Reject"><svg xmlns="http://www.w3.org/2000/svg" width="14.087" height="14.168" viewBox="0 0 14.087 14.168"><defs><style>.a{fill:#fff;stroke:#fff;}</style></defs><path class="a" d="M7.742,6.679l5.1-5.1a.848.848,0,0,0-1.2-1.2l-5.1,5.1-5.1-5.1a.848.848,0,0,0-1.2,1.2l5.1,5.1-5.1,5.1a.848.848,0,1,0,1.2,1.2l5.1-5.1,5.1,5.1a.848.848,0,0,0,1.2-1.2Zm0,0" transform="translate(0.5 0.445)"/></svg></a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php }else{ ?>
    <div class="col-lg-12 col-md-12">
        <div class="contentOrderManagement" style="border-radius: 8px !important;font-size: 15px;padding: 20px;">
            <?php echo "No any order requests available." ?>
        </div>
    </div>
<?php } ?>