<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if ($userid > 0 && $orderid > 0 && $orderitems_id > 0 && $rider_latitude != "" && $rider_longitude != "") {

		$checkUserId = $db->count("user", array("id" => $userid, "usertype" => 2));

		if ($checkUserId > 0) {
			$orderRes = $db->pdoQuery("select * from orders where id = " . $orderid)->result();

			if (!empty($orderRes)) {

				$return_array = array(
					"rider_latitude" 	=> $rider_latitude,
					"rider_longitude" 	=> $rider_longitude,
					"delivery_latitude" => $orderRes['deliverylatitude'],
					"delivery_longitude"=> $orderRes['deliverylongitude'],
					"delivery_address" 	=> $orderRes['deliveryaddress'],
					"mobile_number" 	=> $orderRes['customer_mobileno'] != '' ? $orderRes['customer_mobileno'] : ''
				);

				if ($orderRes['ordertype'] == "package") {
					$orderItemRes = $db->pdoQuery("select * from orderitems where id = " . $orderitems_id . " AND order_id=" . $orderid)->result();

					if ($orderItemRes['status'] == 1) {

						$update_array = array(
							"start_delivery_time" => date('Y-m-d H:i:s'),
							"track_rider_latitude" => $rider_latitude,
							"track_rider_longitude" => $rider_longitude,
							"status"  => 2
						);

						$db->update("orderitems", $update_array, array("id" => $orderitems_id));

						APIsuccess("Delivery time has been started.", $return_array);
					} else {
						APIError("Order already started.");
					}
				}
				else
				{
					if ($orderRes['status'] == 4) {

						$update_array = array(
							"start_delivery_time" => date('Y-m-d H:i:s'),
							"track_rider_latitude" => $rider_latitude,
							"track_rider_longitude" => $rider_longitude,
							"status"  => 5
						);

						$db->update("orders", $update_array, array("id" => $orderid));

						APIsuccess("Delivery time has been started.", $return_array);
					} else {
						APIError("Order already started.");
					}
				}

				/* $res = $db->pdoQuery("SELECT o.deliveryaddress,k.latitude as kitchenlatitude,k.longitude as kitchenlongitude,o.deliverylatitude,o.deliverylongitude,u.mobilenumber
										FROM orders as o 
										LEFT JOIN user as k ON(k.id = o.userid)
										LEFT JOIN user as u ON(u.id = o.customerid)
										WHERE o.id = " . $orderid . " and o.status = 5")->result();
				if (count($res) > 0) {

					$return_array[] = array(
						"kitchenlatitude" => $res['kitchenlatitude'],
						"kitchenlongitude" => $res['kitchenlongitude'],
						"deliverylatitude" => $res['deliverylatitude'],
						"deliverylongitude" => $res['deliverylongitude'],
						"deliveryaddress" => $res['deliveryaddress'],
						"mobilenumber" => $res['mobilenumber'] != '' ? $res['mobilenumber'] : ''
					);

					APIsuccess("Delivery time has been started.", $return_array);
				} else {
					APIError("Order not found.");
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



