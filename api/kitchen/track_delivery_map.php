<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($kitchen_id > 0 && $order_id > 0 && $orderitems_id > 0){

		$checkUserId = $db->count("user", array("id" => $kitchen_id, "usertype" => 0));
        
		if ($checkUserId > 0) {
			$orderRes = $db->pdoQuery("select * from orders where userid = '". $kitchen_id."' AND id = " . $order_id)->result();

			if (!empty($orderRes)) {
				if ($orderRes['ordertype'] == "package") {
					$res = $db->pdoQuery(
						"SELECT o.deliveryaddress,oi.track_rider_latitude as rider_latitude,oi.track_rider_longitude as rider_longitude,o.deliverylatitude,o.deliverylongitude
									FROM orders as o 
									INNER JOIN orderitems as oi ON oi.order_id = o.id
									LEFT JOIN user as k ON(k.id = o.userid)
									WHERE o.id = '" . $order_id . "' AND o.userid=".$kitchen_id." AND oi.id='" . $orderitems_id . "' AND oi.status=2")
						->result();

					if (!empty($res)) {

						$return_array[] = array(
							"rider_latitude" 	=> $res['rider_latitude'],
							"rider_longitude" 	=> $res['rider_longitude'],
							"deliverylatitude" 	=> $res['deliverylatitude'],
							"deliverylongitude" => $res['deliverylongitude'],
							"deliveryaddress" 	=> $res['deliveryaddress']
						);

						APIsuccess("success", $return_array);
					} else {
						APIError("Order not found.");
					}
				}
				else 
				{
					$res = $db->pdoQuery("SELECT o.deliveryaddress,o.track_rider_latitude,o.track_rider_longitude,o.deliverylatitude,o.deliverylongitude
									FROM orders as o 
									LEFT JOIN user as k ON(k.id = o.userid)
									WHERE o.id = " . $order_id . " AND o.userid=".$kitchen_id." AND o.status=5")->result();

					if (!empty($res)) {

						$return_array[] = array(
							"rider_latitude" => $res['track_rider_latitude'],
							"rider_longitude" => $res['track_rider_longitude'],
							"deliverylatitude" => $res['deliverylatitude'],
							"deliverylongitude" => $res['deliverylongitude'],
							"deliveryaddress" => $res['deliveryaddress']
						);

						APIsuccess("success", $return_array);
					} else {
						APIError("Order not found.");
					}
				}
			} else {
				APIError("Invalid order.");
			}

			/* $order = $db->select('orders',array('id'),array('userid'=>$kitchen_id,'id'=>$order_id))->result();

			if($order['id'] > 0){

				$res = $db->pdoQuery("SELECT o.deliveryaddress,k.latitude as kitchenlatitude,k.longitude as kitchenlongitude,o.deliverylatitude,o.deliverylongitude
									FROM orders as o 
									LEFT JOIN user as k ON(k.id = o.userid)
									WHERE o.id = ".$order_id."")->result();
				
				if(!empty($res))
				{
					
					$return_array[] = array(
						"kitchenlatitude"=> $res['kitchenlatitude'],
						"kitchenlongitude"=> $res['kitchenlongitude'],
						"deliverylatitude"=> $res['deliverylatitude'],
						"deliverylongitude"=> $res['deliverylongitude'],
						"deliveryaddress"=> $res['deliveryaddress']
					);

					APIsuccess("success",$return_array);
				}
				else
				{
					APIError("Order not found.");
				}

			}else{
				APIError("Invalid order.");
			} */
		} else {
			APIError("Kitchen not found.");
		}
	}else{
		APIError("Fill all required fields.");
	}	
}
else
{
	APIError("Token missing.");
}