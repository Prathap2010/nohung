<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($userid > 0 && $orderid > 0 && $orderitems_id > 0){

		$checkUserId = $db->count("user", array("id" => $userid, "usertype" => 2));

		if ($checkUserId > 0) {

			$currentOrderRes = $db->pdoQuery("SELECT o.id,oi.id as orderitems_id
							FROM orders AS o
							INNER JOIN orderitems as oi ON oi.order_id = o.id
							WHERE ((o.ordertype='trial' AND (o.status=4 OR o.status=5) AND o.riderid = " . $userid . ") OR (o.ordertype='package' AND o.status=1 AND (oi.status=1 OR oi.status=2) AND oi.riderid = " . $userid . "))
							GROUP BY oi.order_id,oi.delivery_date
							ORDER BY o.id DESC
						")->results();

			if (count($currentOrderRes) <= 0) {

				$orderRes = $db->pdoQuery("select * from orders where id = ". $orderid)->result();

				if(!empty($orderRes)){
					
					if($orderRes['ordertype'] == "package"){

						$orderItemRes = $db->pdoQuery("select * from orderitems where id = " . $orderitems_id. " AND order_id=".$orderid)->result();
						
						if($orderItemRes['status'] == 0){

							$update_array = array(
								"riderid" => $userid,
								"status"  => 1
							);
			
							$db->update("orderitems",$update_array,array("id"=> $orderitems_id));

							APIsuccess("You have accepted this order. Please pick this order from kitchen and deliver on time");
						} 
						else {
							APIError("Order already assined.");
						}
					}else{

						if ($orderRes['status'] == 3) {

							$update_array = array(
								"riderid" => $userid,
								"status"  => "4"
							);

							$db->update("orders", $update_array, array("id" => $orderid));

							APIsuccess("You have accepted this order. Please pick this order from kitchen and deliver on time");
						} else {
							APIError("Order already assined.");
						}
						
					}
					
				}
				else
				{
					APIError("Order not found.");
				}
			} else {
				APIError("First complete your accepted orders.");
			}
			/* $exist =  $db->count("orders",array("status"=>4,'id'=>$orderid));

			if($exist == 0){

				//Update order status
				$update_array = array(
					"riderid" => $userid,
					"status"  => 4
				);

				$db->update("orders",$update_array,array("id"=>$orderid));

				APIsuccess("You have accepted this order. Please pick this order from kitchen and deliver on time");

			}else{
				APIError("This order has been already assiened.");
			} */
		} else {
			APIError("User not found.");
		}
	}else{
		APIError("Fill all required fields.");
	}	
}
else
{
	APIError("Token missing.");
}



