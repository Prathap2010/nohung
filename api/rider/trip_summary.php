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

				if ($orderRes['ordertype'] == "package") {
					$order = $db->select('orderitems', array('id'), array('riderid' => $userid, 'id' => $orderitems_id, 'status' => 3))->result();

					if ($order['id'] > 0) {

						$res = $db->pdoQuery("SELECT oi.start_delivery_time,oi.delivered_datetime,o.deliverycharge,oi.points_gained
										FROM orders as o 
										INNER JOIN orderitems as oi ON oi.order_id = o.id
										WHERE o.id = " . $orderid . " AND oi.id = " . $orderitems_id . " and oi.status = 3")->result();

						$date = date('Y-m-d');
						$today = $db->pdoQuery("SELECT sum(o.deliverycharge) as earnings_today
											FROM orderitems as oi 
											INNER JOIN orders as o ON o.id = oi.order_id
											WHERE oi.status = 3 and oi.riderid = " . $userid . " and DATE(oi.delivered_datetime) = '" . $date . "'")->result();

						if (count($res) > 0) {

							$return_array[] = array(
								"delivery_duration" => get_time_diff($res['start_delivery_time'], $res['delivered_datetime']),
								"trip_earning" => $res['deliverycharge'],
								"point_gained" => $res['points_gained'],
								"earnings_today" => $today['earnings_today'] > 0 ? $today['earnings_today'] : ''


							);

							APIsuccess("success", $return_array);
						} else {
							APIError("Order not found.");
						}
					} else {
						APIError("Invalid order.");
					}
				} else {
					$order = $db->select('orders', array('id'), array('riderid' => $userid, 'id' => $orderid, 'status' => 6))->result();

					if ($order['id'] > 0) {

						$res = $db->pdoQuery("SELECT o.start_delivery_time,o.delivery_time,o.deliverycharge,o.points_gained
										FROM orders as o 
										WHERE o.id = " . $orderid . " and o.status = 6")->result();

						$date = date('Y-m-d');
						$today = $db->pdoQuery("SELECT sum(deliverycharge) as earnings_today
											FROM orders 
											WHERE status = 6 and riderid = " . $userid . " and DATE(delivery_time) = '" . $date . "'")->result();

						if (count($res) > 0) {

							$return_array[] = array(
								"delivery_duration" => get_time_diff($res['start_delivery_time'], $res['delivery_time']),
								"trip_earning" => $res['deliverycharge'],
								"point_gained" => $res['points_gained'],
								"earnings_today" => $today['earnings_today'] > 0 ? $today['earnings_today'] : ''


							);

							APIsuccess("success", $return_array);
						} else {
							APIError("Order not found.");
						}
					} else {
						APIError("Invalid order.");
					}
				}
				/* $order = $db->select('orders',array('id'),array('riderid'=>$userid,'id'=>$orderid,'status'=>6))->result();

				if($order['id'] > 0){

					$res = $db->pdoQuery("SELECT o.start_delivery_time,o.delivery_time,o.deliverycharge,o.points_gained
										FROM orders as o 
										WHERE o.id = ".$orderid." and o.status = 6")->result();
					
					$date = date('Y-m-d');
					$today = $db->pdoQuery("SELECT sum(deliverycharge) as earnings_today
											FROM orders 
											WHERE status = 6 and riderid = ".$userid." and DATE(delivery_time) = '".$date."'")->result();

					//print_r($today);exit;
					if(count($res) > 0)
					{
						
						$return_array[] = array(
							"delivery_duration"=> get_time_diff($res['start_delivery_time'],$res['delivery_time']),
							"trip_earning"=> $res['deliverycharge'],
							"point_gained"=> $res['points_gained'],
							"earnings_today"=> $today['earnings_today'] > 0 ? $today['earnings_today'] : ''

							
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
				APIError("Order not found.");
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



