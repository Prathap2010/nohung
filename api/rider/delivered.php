<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($userid > 0 && $orderid > 0 && $orderitems_id > 0){

		$checkUserId = $db->count("user", array("id" => $userid, "usertype" => 2));

		if ($checkUserId > 0) {
			$orderRes = $db->pdoQuery("select * from orders where id = " . $orderid)->result();

			if (!empty($orderRes)) {
                
				$sitesetting = $db->select('sitesetting', array('points_per_km', 'mapapikey'), array('id' => 1))->result();

				if ($orderRes['ordertype'] == "package") {
                    
					$res = $db->pdoQuery("SELECT o.deliveryaddress,cu.mobilenumber as foodie_mobilenumber,k.mobilenumber as kitchen_mobilenumber, k.address as kitchenaddress,oi.status as itemstatus
										FROM orders as o 
										INNER JOIN orderitems as oi ON oi.order_id = o.id
										LEFT JOIN user as k ON(k.id = o.userid)
										LEFT JOIN user as cu ON(cu.id = o.customerid)
										WHERE o.id = '" . $orderid . "' AND oi.riderid='".$userid."' AND oi.id='".$orderitems_id."'")->result();
					if (!empty($res) && $res['itemstatus']==2) {
						$resDistance = json_decode(get_duration_between_two_places($sitesetting['mapapikey'], $res['kitchenaddress'], $res['deliveryaddress'], 'both', 1));
						$trip_distance = str_replace(",", "", $resDistance->distance);

						$points_gained = $sitesetting['points_per_km'] * round($trip_distance);
						$db->pdoQuery("update user set wallet = wallet + " . $orderRes['deliverycharge'] . ",points_gained = points_gained + " . $points_gained . " WHERE id = " . $userid . "");

						$update_array['status'] = 3;
						$update_array['points_gained'] = $points_gained;
						$update_array['delivered_datetime'] = date('Y-m-d H:i:s');
						
						$db->update('orderitems', $update_array, array('id' => $orderitems_id));
					} else {
						APIError("Invalid order.");
					}
				} else {
					$res = $db->pdoQuery("SELECT o.deliveryaddress,cu.mobilenumber as foodie_mobilenumber,k.mobilenumber as kitchen_mobilenumber, k.address as kitchenaddress,o.status as orderstatus
										FROM orders as o 
										LEFT JOIN user as k ON(k.id = o.userid)
										LEFT JOIN user as cu ON(cu.id = o.customerid)
										WHERE o.id = '" . $orderid . "' AND o.riderid='".$userid."'")->result();

					if (!empty($res) && $res['orderstatus'] == 5) {
						$resDistance = json_decode(get_duration_between_two_places($sitesetting['mapapikey'], $res['kitchenaddress'], $res['deliveryaddress'], 'both', 1));
						$trip_distance = str_replace(",", "", $resDistance->distance);

						$points_gained = $sitesetting['points_per_km'] * round($trip_distance);
						$db->pdoQuery("update user set wallet = wallet + " . $orderRes['deliverycharge'] . ",points_gained = points_gained + " . $points_gained . " WHERE id = " . $userid . "");

						$update_array['status'] = 6;
						$update_array['points_gained'] = $points_gained;
						$update_array['delivery_time'] = date('Y-m-d H:i:s');
						$update_array['modifieddate'] = date('Y-m-d H:i:s');
						$db->update('orders', $update_array, array('id' => $orderid));
					}else{
						APIError("Invalid order.");
					}
				}
				
				$return_array[] = array(
					"deliveryaddress" 		=> $res['deliveryaddress'],
					"foodie_mobilenumber" 	=> $res['foodie_mobilenumber'],
					"kitchen_mobilenumber" 	=> $res['kitchen_mobilenumber']
				);

				APIsuccess("You delivered this order.", $return_array);

				/* $order = $db->select('orders',array('id','deliverycharge'),array('riderid'=>$userid,'id'=>$orderid,'status'=>5))->result();

				if($order['id'] > 0){

					$res = $db->pdoQuery("SELECT o.deliveryaddress,cu.mobilenumber,k.kitchencontactnumber,getDistance(k.latitude,k.longitude,r.latitude,r.longitude) as distance
										FROM orders as o 
										LEFT JOIN user as k ON(k.id = o.userid)
										LEFT JOIN user as cu ON(cu.id = o.customerid)
										LEFT JOIN user as r ON(r.id = o.riderid)
										WHERE o.id = ".$orderid."")->result();
					
					//Update delivery amount and points in rider wallet
					$sitesetting = $db->select('sitesetting',array('points_per_km'),array('id'=>1))->result();
					$points_gained = $sitesetting['points_per_km'] * round($res['distance']);
					$db->pdoQuery("update user set wallet = wallet + ".$order['deliverycharge'].",points_gained = points_gained + ".$points_gained." WHERE id = ".$userid."");

					//Update order status
					$update_array['status'] = 6;
					$update_array['points_gained'] = $points_gained;
					$update_array['delivery_time'] = date('Y-m-d H:i:s');
					$update_array['modifieddate'] = date('Y-m-d H:i:s');
					$db->update('orders',$update_array,array('id'=>$orderid));


					if(count($res) > 0)
					{
						
						$return_array[] = array(
							"deliveryaddress"=> $res['deliveryaddress'],
							"foodie_mobilenumber"=> $res['mobilenumber'] !='' ? $res['mobilenumber'] : '',
							"kitchen_mobilenumber"=> $res['kitchencontactnumber'] !='' ? $res['kitchencontactnumber'] : ''
						);

						APIsuccess("You delivered this order.",$return_array);
					}
					else
					{
						APIError("Order not found.");
					}

				}else{
					APIError("Invalid order.");
				} */
			} else {
				APIError("Invalid order.");
			}
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



