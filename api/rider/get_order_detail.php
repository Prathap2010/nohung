<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($userid > 0){

		$res = $db->pdoQuery("SELECT o.pickstart,o.pickend,k.kitchenname,k.address as kitchen_address,k.kitchencontactnumber,u.kitchenname as customername,o.deliveryaddress
	                          FROM orders as o 
						      LEFT JOIN user as k ON(k.id = o.userid)
							  LEFT JOIN user as u ON(u.id = o.customerid)
						      WHERE o.id = ".$orderid)->result();
		//print_r($res);exit;
		if(count($res) > 0)
		{
			$items = $db->pdoQuery('select GROUP_CONCAT(item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$orderid)->result();
			
			$return_array[] = array(
				"orderid"              => $orderid,
				"pickby"               => $res['pickstart'].' To '.$res['pickend'],
				"status"               => 'Ready to pick',
				"kitchenname"          => $res['kitchenname'],
				"kitchen_address"      => $res['kitchen_address'],
				"kitchencontactnumber" => $res['kitchencontactnumber'],
				"customername"         => $res['customername'],
				"deliveryaddress"      => $res['deliveryaddress'],
				"item_details"         => $items['item_name']
			);

			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Order not found.");
		}

	}else{
		APIError("Fill all required fields.");
	}	
}
else
{
	APIError("Token missing.");
}



