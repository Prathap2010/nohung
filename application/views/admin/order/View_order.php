<div class="page-content">
    <div class="page-heading">    
        <h1>View Order</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li>Order Management</li>
            <li class="active">View Order</li>
          </ol>
        </small>                
    </div>

    <style>
        thead tr.bg_header {
            background-color: #006DCC;
            color: white;
        }
        thead tr.bg_header:hover {
            background-color: #006DCC;
            color: black;
        }

    </style>

    <div class="container-fluid">
                                    
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                
                <h2>Order Details</h2>
                
              </div>
              <div class="panel-body">
                <div class="col-md-6 p-n">
                    <table class="table table-bordered mb-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr class="bg_header">            
                            <th colspan="2">Order Details</th>
                        </tr>
                        <tr>            
                            <th width="30%">OrderID</th>
                            <td><?=$orderdata['orderid']?></td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td><?=$this->general_model->displaydate($orderdata['orderdate'])?></td>
                        </tr>
                        <tr>
                            <th>Delivery Address</th>
                            <td><?=$orderdata['deliveryaddress']?></td>
                        </tr>
                        <tr>
                            <th>Ordering for</th>
                            <td><?=$orderdata['orderingforname']?>, <?=$orderdata['orderingformobileno']?></td>
                        </tr>

                        <tr>
                            <th>Order Amount</th>
                            <td><?=number_format($orderdata['orderamount'],2,'.',',')?></td>
                        </tr>
                        <tr>
                            <th>Tax Amount</th>
                            <td><?=number_format($orderdata['taxamount'],2,'.',',')?></td>
                        </tr>
                        <tr>
                            <th>Delivery Charge</th>
                            <td><?=number_format($orderdata['deliverycharge'],2,'.',',')?></td>
                        </tr>
                        <tr>
                            <th>Coupon Code</th>
                            <td><?=($orderdata['couponcode'] != "" ? $orderdata['couponcode'] : "-")?></td>
                        </tr>
                        <tr>
                            <th>Coupon Amount</th>
                            <td><?=number_format($orderdata['couponamount'],2,'.',',')?></td>
                        </tr>
                        <tr>
                            <th>Net Amount</th>
                            <td><?=number_format($orderdata['netamount'],2,'.',',')?></td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td><?php 
                                if($orderdata['paymentmethod'] == 0){
                                    echo "Wallet";
                                } else if($orderdata['paymentmethod'] == 1){
                                    echo "Payumoney";
                                }?>
                            </td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td>
                            <?php if($orderdata['status']==0){
                                    echo '<span class="label label-warning">Pending</span>';
                                }else if($orderdata['status']==1){
                                    echo '<span class="label label-success">Approved</span>';
                                }else if($orderdata['status']==2){
                                    echo '<span class="label label-danger">Rejected</span>';
                                }else if($orderdata['status']==3){
                                    echo '<span class="label label-gray">Ready to Pick</span>';
                                }else if($orderdata['status']==4){
                                    echo '<span class="label label-info">Assign to rider</span>';
                                }else if($orderdata['status']==5){
                                    echo '<span class="label label-orange">Start delivery</span>';
                                }else if($orderdata['status']==6){
                                    echo '<span class="label label-green">Delivered</span>';
                                }else if($orderdata['status']==7){
                                    echo '<span class="label label-danger">Cancelled</span>';
                                }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Created Time</th>
                            <td><?=$this->general_model->displaydatetime($orderdata['createddate']);?></td>
                        </tr>
                      </thead>
                      
                    </table>
                </div>
                <div class="col-md-6 p-n pl-sm">
                    <table class="table table-bordered mb-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr class="bg_header">            
                            <th colspan="2">Kitchen Details</th>
                        </tr>
                        <tr>            
                            <th width="25%">Name</th>
                            <td><?=$orderdata['kitchenname']?></td>
                        </tr>
                        <tr>
                            <th>Mobile No.</th>
                            <td>+91 <?=$orderdata['kitchen_mobileno']?></td>
                        </tr>
                        <tr>
                            <th>E-mail ID</th>
                            <td><?=$orderdata['kitchen_email']?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?=$orderdata['kitchen_address']?></td>
                        </tr>
                      </thead>
                      
                    </table>
                    <table class="table table-bordered mb-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr class="bg_header">            
                            <th colspan="2">Foodie Details</th>
                        </tr>
                        <tr>            
                            <th width="25%">Name</th>
                            <td><?=$orderdata['customer_name']?></td>
                        </tr>
                        <tr>
                            <th>Mobile No.</th>
                            <td>+91 <?=$orderdata['customer_mobileno']?></td>
                        </tr>
                        <tr>
                            <th>E-mail ID</th>
                            <td><?=$orderdata['customer_email']?></td>
                        </tr>
                      </thead>
                      
                    </table>
                    <table class="table table-bordered mb-sm" cellspacing="0" width="100%">
                      <thead>
                        <tr class="bg_header">            
                            <th colspan="2">Rider Details</th>
                        </tr>
                        <tr>            
                            <th width="25%">Name</th>
                            <td><?=($orderdata['rider_name'] != "" ? $orderdata['rider_name'] : "-")?></td>
                        </tr>
                        <tr>
                            <th>Mobile No.</th>
                            <td><?=($orderdata['rider_mobileno'] != "" ? "+91 ".$orderdata['rider_mobileno'] : "-")?></td>
                        </tr>
                        <tr>
                            <th>E-mail ID</th>
                            <td><?=($orderdata['rider_email'] != "" ? $orderdata['rider_email'] : "-")?></td>
                        </tr>
                      </thead>
                      
                    </table>
                </div>

                <div class="col-md-12 p-n">
                    <table class="table table-bordered mb-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg_header">            
                                <th colspan="<?=($orderdata['ordertype'] == "trial" ? "6" : "7") ?>">Order Item Details</th>
                            </tr>
                            <tr>            
                                <th class="width5">No.</th>
                                <th>Item Name</th>
                                <th>Cuisine</th>
                                <?php if($orderdata['ordertype'] == "trial"){ ?>
                                    <th class="text-right">Qty.</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Total Amount</th>
                                <?php }else{ ?>
                                    <th>Delivery Date</th>
                                    <th>Delivery Time</th>
                                    <th>Status</th>
                                    <th class="text-right">Amount</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody><?php
                            if(!empty($orderdata['orderitems'])){
                                foreach($orderdata['orderitems'] as $i=>$row){ ?> 
                                    <tr>            
                                        <td><?=($i+1)?></td>
                                        <td><?=$row['menu_name']?></td>
                                        <td><?=$row['cuisinetypename']?></td>
                                        <?php if($orderdata['ordertype'] == "trial"){ ?>
                                            <td class="text-right"><?=($row['mealplan']==2 ? $row['quantity'] : "-")?></td>
                                            <td class="text-right"><?=number_format($row['item_price'],2,'.',',')?></td>
                                            <td class="text-right"><?=number_format(($row['item_price'] * $row['quantity']),2,'.',',')?></td>
                                        <?php }else{ ?>
                                            <td><?=$this->general_model->displaydate($row['delivery_date'])?></td>
                                            <td><?=date("H:i A",strtotime($row['delivery_fromtime']))."-".date("H:i A",strtotime($row['delivery_totime']))?></td>
                                            <td><?php
                                                if($row['status'] == 0) {
                                                    echo "<label class='label label-gray'>Ready to Pick</span>";
                                                }else if($row['status'] == 1) {
                                                    echo "<label class='label label-info'>Assign to Rider</span>";
                                                }else if($row['status'] == 2) {
                                                    echo "<label class='label label-info'>Start Delivery</span>";
                                                }else if($row['status'] == 3) {
                                                    echo "<label class='label label-success'>Delivered</span>";
                                                }else if($row['status'] == 4) {
                                                    echo "<label class='label label-danger'>Cancelled</span>";
                                                }else if($row['status'] == 5) {
                                                    echo "<label class='label label-warning'>Pending</span>"; 
                                                } ?>
                                            </td>
                                            <td class="text-right"><?=number_format($row['item_price'],2,'.',',')?></td>
                                        <?php } ?>
                                    </tr>   
                            <?php }
                            }else{ ?>
                                <tr>            
                                    <th colspan="6" class="text-center">Order item not available.</th>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->