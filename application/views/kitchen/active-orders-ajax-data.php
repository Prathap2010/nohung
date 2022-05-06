<?php if(!empty($active_orders)){
    foreach($active_orders as $order){ ?>
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
                            <img src="<?php echo KITCHEN_IMAGES_URL ?>indian_food_Lunch.svg" alt="">
                            <h5><?=$order['item_name']?></h5>
                        </div>
                    </div>
                </div>
                <div class="orderManagementFooter">
                    <div class="orderManagementAddress">
                        <img src="<?php echo KITCHEN_IMAGES_URL ?>location_icons.svg" alt="">
                        <p class="text-ellipsis"><?=$order['deliveryaddress']?></p>
                        <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="32" height="15.5" viewBox="0 0 32 15.5"><defs><style>.a{fill:#fff;}</style></defs><path class="a" d="M31.633,138.865h0l-6.531-6.5a1.25,1.25,0,0,0-1.764,1.772l4.385,4.364H1.25a1.25,1.25,0,0,0,0,2.5H27.722l-4.385,4.364a1.25,1.25,0,0,0,1.764,1.772l6.531-6.5h0A1.251,1.251,0,0,0,31.633,138.865Z" transform="translate(0 -132)"></path></svg></a>
                    </div>
                    <div class="orderManagementOptionButton">
                        <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?=($order['delivery_fromtime']!="00:00:00"?date("h:i A", strtotime($order['delivery_fromtime'])):"")?></span>
                        <?php if($order['ordertype'] == "package"){
                            if($order['itemstatus']==5){ ?>
                                <a class="ReadyToPickUpButotn" href="javascript:void(0)" id="ReadyToPickUpButotn_<?=$order['orderitemsid']?>" onclick="changeorderstatus(<?=$order['orderitemsid']?>,0,'package')"><span id="status_<?=$order['orderitemsid']?>">Ready to Pick-up</span> <svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                            <?php }elseif($order['itemstatus']==0){ ?>
                                <a class="ReadyToPickUpButotn" href="javascript:void(0)">Ready to Picked-up <svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                            <?php }elseif($order['itemstatus']==1){ ?>
                                <a class="ReadyToPickUpButotn" href="javascript:void(0)">Assigned to Rider <svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                            <?php }elseif($order['itemstatus']==2){ ?>
                                <a class="ReadyToPickUpButotn" href="javascript:void(0)">Started Delivery <svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                            <?php }
                        }else{
                            if($order['status']==1){ ?>
                                <a class="ReadyToPickUpButotn" href="javascript:void(0)" 
                                id="ReadyToPickUpButotn_<?=$order['id']?>" onclick="changeorderstatus(<?=$order['id']?>,3,'trial')"><span id="status_<?=$order['id']?>">Ready to Pick-up</span> <svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                            <?php }elseif($order['status']==3){ ?>
                                <a class="ReadyToPickUpButotn" href="javascript:void(0)">Ready to Picked-up <svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                            <?php }elseif($order['status']==4){ ?>
                                <a class="ReadyToPickUpButotn" href="javascript:void(0)">Assigned to Rider <svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                            <?php }elseif($order['status']==5){ ?>
                                <a class="ReadyToPickUpButotn" href="javascript:void(0)">Started Delivery <svg xmlns="http://www.w3.org/2000/svg" width="13.293" height="12" viewBox="0 0 13.293 12"><defs><style>.a{fill:#7edabf;}.b{fill:none;}</style></defs><g transform="translate(0 3)"><path class="a" d="M6.338,7.246,2,2.908,3.292,1.615,6.338,4.662,14-3l1.292,1.292Z" transform="translate(-2)"/><rect class="b" width="9" height="9"/></g></svg></a>
                            <?php }
                        } ?>
                        
                    </div>
                </div>
            </div>
        </div>
<?php }
}else{ ?>
    <div class="col-lg-12 col-md-12">
        <div class="contentOrderManagement">
            <p style="color:#7e7f7f;">No any active orders available.</p>
        </div>
    </div> 
<?php } ?>