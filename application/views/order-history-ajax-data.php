<?php if(!empty($order_history)){
    foreach($order_history as $order){ ?>
        
        <?php if($order['ordertype'] == "package"){
            
            foreach($order['package_detail'] as $package){ ?>

                <div class="orderhistory-container">
                    <div class="orderhistory-headings">
                        <div class="left-part">
                            <div class="order-history-menu">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="main-heading"><?=$package['item_name']?></li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-order-lunch-tab" data-toggle="pill" href="#pills-order-lunch" role="tab" aria-controls="pills-order-lunch" aria-selected="true"><?=$package['menu']?></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-order-veg-tab" data-toggle="pill" href="#pills-order-veg" role="tab" aria-controls="pills-order-veg" aria-selected="false"><img src="<?=FRONT_IMAGES_URL?>vegFood_icon.png" alt="" class="img-fluid"><?=$package['mealtype']?></a> 
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-order-nim-tab" data-toggle="pill" href="#pills-order-nim" role="tab" aria-controls="pills-order-nim" aria-selected="false"><?=$package['cuisine']?> Meals</a> 
                                    </li>
                                </ul>
                            </div>            
                        </div>
                        <div class="right-part">
                            <p class="orderdatewithnum"><span><?=$order['orderid']?> </span>|<span> Order From <?=date("d M",strtotime($package['startdate']))?> to <?=date("d M, Y",strtotime($package['enddate']))?></span></p>
                        </div>
                    </div>
                </div>
                <div class="orderhistorybody">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order-lunch" role="tabpanel" aria-labelledby="pills-order-lunch-tab">
                            <div class="order-lunch-container-main">
                                <?php if(!empty($package['daily_pkg_detail'])){
                                    foreach($package['daily_pkg_detail'] as $row){ ?>
                                        <div class="order-lunch-content">
                                            <div class="day-meal">
                                                <p class="main-heading"><?=date("l, d M, Y", strtotime($row['delivery_date']))?></p>
                                                <p class="description"><?=$row['dish_item']?></p>
                                            </div>
                                            <div class="time"><?=date("h:i", strtotime($row['delivery_fromtime']))."-".date("H:i", strtotime($row['delivery_totime']))?></div>
                                            <div class="price">₹<?=number_format($row['total_amount'],2,'.',',')?></div>
                                            <div class="btn-container">
                                                <?php if($row['status']==3){
                                                    echo '<a href="javascript:void(0)" class="btn-delivered">Delivered</a>';
                                                }else if($row['status']==4){
                                                    echo '<a href="javascript:void(0)" class="btn-cancelled">Cancelled</a>';
                                                }else if($row['status']==5 || $row['status']==2 || $row['status']==1 || $row['status']==0){
                                                    echo '<a href="javascript:void(0)" class="btn-upcoming">Upcoming</a>';
                                                } ?>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            
                                
                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-order-veg" role="tabpanel" aria-labelledby="pills-order-veg-tab">...</div>
                        <div class="tab-pane fade" id="pills-order-nim" role="tabpanel" aria-labelledby="pills-order-nim-tab">...</div>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <div class="order-active-content">
                <div class="name-bill">
                    <div class="left-part">
                        <p class="kitchen-name"><?=$order['kitchenname']?></p>
                        <p class="order-date"><?=$order['orderid']?> | Order from <?=date("d M, Y",strtotime($order['orderdate']))?></p>
                        <p class="rate">
                            <?php for($i=1; $i<=5; $i++){ 
                                
                                $class = "";
                                if($i > $order['kitchen_rating']){
                                   $class = "cementgray";
                                } 
                                ?>
                                <i class="fa fa-star <?=$class?>"></i>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="right-part">
                        <p class="total-bill">Total Bill: ₹<?=number_format($order['netamount'],2,'.',',')?></p>
                    </div>
                </div>
                <div class="btn-container">
                    <div class="left-part"><button class="btn-active">
                        <?php if($order['order_status'] == "0"){
                            echo "Pending";
                        }else if($order['order_status'] == "1"){
                            echo "Order in Preparation";
                        }else if($order['order_status'] == "2"){
                            echo "Rejected";
                        }else if($order['order_status'] == "3"){
                            echo "REady to picked";
                        }else if($order['order_status'] == "4"){
                            echo "Assign to Rider";
                        }else if($order['order_status'] == "5"){
                            echo "Start Delivery";
                        }else if($order['order_status'] == "6"){
                            echo "Delivered";
                        }else if($order['order_status'] == "7"){
                            echo "Cancelled";
                        }    ?></button>
                    </div>
                </div>
            </div>
        <?php } ?> 
    <?php }
}else{ ?>
    <div class="col-lg-12 col-md-12">
        <div class="contentOrderManagement">
            <p style="color:#7e7f7f;">No any orders available.</p>
        </div>
    </div> 
<?php } ?>