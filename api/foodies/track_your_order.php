<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($orderid > 0){

		$res = $db->pdoQuery("SELECT o.pickstart,o.pickend,o.status,r.kitchenname as rider_name,r.mobilenumber as rider_contact,k.kitchenname,k.kitchenid,k.mobilenumber as kitchen_contact,k.address
							  FROM orders as o
							  LEFT JOIN user as r ON(o.riderid = r.id)
							  LEFT JOIN user as k ON(o.userid = k.id)
							  WHERE o.id = ".$orderid)->result();
		
		//echo '<pre>';print_r($res);exit;
		
		if(count($res) > 0)
		{
			
			$items = $db->pdoQuery('select GROUP_CONCAT(item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$orderid)->result();

			if($res['status'] == 0){
				$status = 'Pending for approval';
			}else if($res['status'] == 1){
				$status = 'Approved by kitchen';
			}else if($res['status'] == 3){
				$status = 'Ready to pick';
			}else if($res['status'] == 4){
				$status = 'Order dispatched';
			}else if($res['status'] == 5){
				$status = 'Start delivery';
			}else if($res['status'] == 6){
				$status = 'Delivered';
			}
			
			$return_array[] = array(
				"arriving_by"      => $res['pickstart'].' To '.$res['pickend'],
				"order_status"     => $status,
				"rider_name"      => $res['rider_name'],
				"rider_contact"      => $res['rider_contact'],
				"kitchenname"      => $res['kitchenname'],
				"kitchenid"      => $res['kitchenid'],
				"kitchen_contact"      => $res['kitchen_contact'],
				"menu_items"      => $items['item_name'],
				"kitchen_address"      => $res['address']
			);
		
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Order not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
	
}
else
{
	APIError("Token missing.");
}



