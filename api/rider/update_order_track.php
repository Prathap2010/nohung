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

					if ($orderItemRes['status'] == 2) {

						$update_array = array(
							"track_rider_latitude" => $rider_latitude,
							"track_rider_longitude" => $rider_longitude,
						);

						$db->update("orderitems", $update_array, array("id" => $orderitems_id));

						APIsuccess("Location updated successfully.", $return_array);
					} else {
						APIError("Order delivery already started.");
					}
				}
				else
				{
					if ($orderRes['status'] == 5) {

						$update_array = array(
							"track_rider_latitude" => $rider_latitude,
							"track_rider_longitude" => $rider_longitude,
						);

						$db->update("orders", $update_array, array("id" => $orderid));

                        APIsuccess("Location updated successfully.", $return_array);
					} else {
						APIError("Order delivery already started.");
					}
				}
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



