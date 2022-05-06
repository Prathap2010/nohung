<?php if(!empty($active_orders)){ 
    foreach($active_orders as $i=>$row){ ?>
        <div class="order-active-content">
            <div class="name-bill">
                <div class="left-part">
                    <p class="kitchen-name"><?=$row['kitchenname']?></p>
                    <p class="order-date"><?=$row['orderid']?> | Order from <?=date("d M, Y",strtotime($row['delivery_date']))?></p>
                    <p class="rate"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star cementgray"></i></p>
                </div>
                <div class="right-part">
                    <p class="total-bill">Total Bill: ₹<?=number_format($row['netamount'],2,'.',',')?></p>
                </div>
            </div>
            <div class="btn-container">
                <div class="left-part"><a href="javascript:void(0)" class="btn-active">Active</a></div>
                <!-- <div class="right-part"><a href="javascript:void(0)" class="btn-view-details">View Details</a></div> -->
            </div>
        </div>
    <?php } ?>
<?php }else{ ?>
    <div class="order-active-content">
        <p class="text-center">No any active order available.</p>
    </div>
<?php } ?>