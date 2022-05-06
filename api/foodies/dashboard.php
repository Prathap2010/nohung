<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0){

		$res = $db->pdoQuery("SELECT k.kitchenname,p.packagename,m.itemname,oi.mealplan,o.id
							  FROM orders as o
							  LEFT JOIN orderitems as oi ON(oi.order_id = o.id)
							  LEFT JOIN user as k ON(o.userid = k.id)
							  LEFT JOIN mastermenu as m ON(m.id = oi.reference_id)
							  LEFT JOIN packages as p ON(p.id = oi.reference_id)
							  WHERE o.customerid = ".$userid." AND oi.delivery_date = '".date('Y-m-d')."'")->result();
		
		//echo '<pre>';print_r($res);exit;
		
		if($res['id'] > 0)
		{

			$return_array[] = array(
				"id"   => $res['id'],
				"kitchenname"   => $res['kitchenname'],
				"item"          => $res['mealplan'] == 2 ? $res['itemname'] : $res['packagename'],
				"arriving"      => '11:00 PM'
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



