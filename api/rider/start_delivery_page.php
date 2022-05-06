<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($userid > 0 && $orderid > 0){

		$order = $db->select('orders',array('id'),array('riderid'=>$userid,'id'=>$orderid,'status'=>4))->result();

		if($order['id'] > 0){

			$res = $db->pdoQuery("SELECT o.deliveryaddress,k.latitude as kitchenlatitude,k.longitude as kitchenlongitude,o.deliverylatitude,o.deliverylongitude
	                              FROM orders as o 
						          LEFT JOIN user as k ON(k.id = o.userid)
							      WHERE o.id = ".$orderid." and o.status = 4")->result();
			//print_r($res);exit;
			if(count($res) > 0)
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
		}

	}else{
		APIError("Fill all required fields.");
	}	
}
else
{
	APIError("Token missing.");
}



