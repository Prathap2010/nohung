<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if ($userid > 0 && $orderid > 0 && $orderitems_id > 0) {

		$checkUserId = $db->count("user", array("id" => $userid, "usertype" => 2));

		if ($checkUserId > 0) {

			$orderRes = $db->pdoQuery("select * from orders where id = " . $orderid)->result();

			if (!empty($orderRes)) {

				if ($orderRes['ordertype'] == "package") {

					$reject = $db->count("rejectedorders", array("orderid" => $orderid, "orderitems_id" => $orderitems_id, 'riderid' => $userid));

					if ($reject == 0) {
						//Update order status
						$insert_array = array(
							"riderid" => $userid,
							"orderid"  => $orderid,
							"orderitems_id" => $orderitems_id,
							"createddate" => date('Y-m-d H:i:s')
						);

						$db->insert("rejectedorders", $insert_array);

						APIsuccess("You have rejected this order.");
					} else {
						APIError("You have already rejected this order.");
					}
				} 
				else 
				{
					$reject = $db->count("rejectedorders", array("orderid" => $orderid, 'riderid' => $userid));

					if ($reject == 0) {
						//Update order status
						$insert_array = array(
							"riderid" => $userid,
							"orderid"  => $orderid,
							"orderitems_id" => $orderitems_id,
							"createddate" => date('Y-m-d H:i:s')
						);

						$db->insert("rejectedorders", $insert_array);

						APIsuccess("You have rejected this order.");
					} else {
						APIError("You have already rejected this order.");
					}
				}
			} 
			else 
			{
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



