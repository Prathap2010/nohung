<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if(isset($userid) && $userid > 0){

		$checkUserId = $db->count("user", array("id" => $userid, "usertype" => 2));

		if ($checkUserId > 0) {

			
			$res_setting = $db->pdoQuery("select radius_in_km,delivery_charge_per_km,mapapikey from sitesetting where id = 1")->result();

			$res = $db->pdoQuery("SELECT o.netamount,o.deliverycharge,o.id,oi.id as orderitems_id,k.kitchenname,oi.delivery_fromtime,oi.delivery_totime,o.deliveryaddress,o.status,oi.status,k.address as kitchenaddress,o.ordertype
							FROM orders AS o
							INNER JOIN orderitems as oi ON oi.order_id = o.id
							LEFT JOIN user as k ON(k.id = o.userid)
							LEFT JOIN user as r ON(r.id = " . $userid . ")
							WHERE ((o.ordertype='trial' AND o.status=3 AND o.riderid = 0) OR (o.ordertype='package' AND o.status=1 AND oi.status=0 AND oi.riderid = 0)) AND oi.delivery_date <= CURDATE()
							GROUP BY oi.order_id,oi.delivery_date
							ORDER BY o.id DESC
						")->results();

			if (count($res) > 0) {
				$distance = $orderamount = 0;
				foreach ($res as $value) {

					if ($value['ordertype'] == "package") {
						$reject = $db->pdoQuery("SELECT * FROM rejectedorders WHERE orderid=".$value['id']." AND orderitems_id=".$value['orderitems_id']." AND riderid=".$userid)->result();
					}
					else
					{
						$reject = $db->pdoQuery("SELECT * FROM rejectedorders WHERE orderid=".$value['id']." AND riderid=".$userid)->result();
					}

					if(empty($reject)){

						$resDistance = json_decode(get_duration_between_two_places($res_setting['mapapikey'],$value['kitchenaddress'], $value['deliveryaddress'], 'both', 1));
	
						$total_distance = str_replace(",", "", $resDistance->distance);
						if ($total_distance <= $res_setting['radius_in_km'] || $res_setting['radius_in_km'] == 0) {
						
							$distance += $total_distance;
							$orderamount += $value['deliverycharge'];
			
							$return_array[] = array(
								"orderid"         => $value['id'],
								"orderitems_id"   => $value['orderitems_id'],
								"ordertype"		  => $value['ordertype'],
								"kitchenname"     => $value['kitchenname'],
								"picktime"        => date("h:i", strtotime($value['delivery_fromtime'])) . '-' . date("h:i", strtotime($value['delivery_totime'])),
								"deliveryaddress" => $value['deliveryaddress'],
								"status"          => 'Ready to pick'
							);
						}
					}

				}

				$global_array['trip_distance'] = round($distance);
				$global_array['expected_earnings'] = $orderamount;

				APIsuccess("success", $return_array, '', '', '', $global_array);
			} else {
				APIError("Orders not found.");
			}
		
			/* $res = $db->pdoQuery("SELECT o.netamount,o.deliverycharge,ro.id as rejectid,o.id,k.kitchenname,o.pickstart,o.pickend,o.deliveryaddress,getDistance(k.latitude,k.longitude,r.latitude,r.longitude) as distance,o.status
								FROM orders as o 
								LEFT JOIN user as k ON(k.id = o.userid)
								LEFT JOIN user as r ON(r.id = ".$userid.")
								LEFT JOIN rejectedorders as ro ON(ro.orderid = o.id and ro.riderid = ".$userid.")
								WHERE o.status 
								HAVING distance <= (select radius_in_km from sitesetting where id = 1) and rejectid IS NULL
								ORDER BY o.id DESC")->results();
			if(count($res) > 0)
			{	
				$distance = $orderamount = 0;
				foreach ($res as $value) {

					$distance += $value['distance'];
					$orderamount += $value['deliverycharge'];

					$return_array[] = array(
						"orderid"         => $value['id'],
						"kitchenname"     => $value['kitchenname'],
						"picktime"        => $value['pickstart'].'-'.$value['pickend'],
						"deliveryaddress" => $value['deliveryaddress'],
						"status"          => 'Ready to pick'
					);
				}

				$global_array['trip_distance'] = round($distance);
				$global_array['expected_earnings'] = $orderamount;
				
				APIsuccess("success",$return_array,'','','',$global_array);
			}
			else
			{
				APIError("Orders not found.");
			} */
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