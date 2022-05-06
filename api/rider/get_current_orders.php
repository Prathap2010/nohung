<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if(isset($userid) && $userid > 0){

		$checkUserId = $db->count("user", array("id" => $userid, "usertype" => 2));

		if ($checkUserId > 0) {

			$res = $db->pdoQuery("SELECT o.id,oi.id as orderitems_id,o.deliveryaddress,o.status as orderstatus,oi.status as itemstatus,o.ordertype
							FROM orders AS o
							INNER JOIN orderitems as oi ON oi.order_id = o.id
							WHERE ((o.ordertype='trial' AND (o.status=4 OR o.status=5) AND o.riderid = " . $userid . ") OR (o.ordertype='package' AND o.status=1 AND (oi.status=1 OR oi.status=2) AND oi.riderid = " . $userid . "))
							GROUP BY oi.order_id,oi.delivery_date
							ORDER BY o.id DESC
						")->result();

			if(!empty($res)){
				if ($res['ordertype'] == "package") {
					$status = ($res['itemstatus'] == 1) ? "Assign to rider" : "Start delivery";
				}else{
					$status = ($res['orderstatus']==4) ? "Assign to rider" : "Start delivery";
				}
                $return_array[]=array(
					'order_id'		 => $res['id'],
					'orderitems_id'	 => $res['orderitems_id'],
					'deliveryaddress'=> $res['deliveryaddress'],
					'status'		 => $status
				);
	
                APIsuccess("success", $return_array);
			}else{
				APIError("Order not found.");
			}
		} else {
			APIError("User not found.");
		}
	}else{
		APIError("Invalid user id.");
	}	
}
else
{
	APIError("Token missing.");
}