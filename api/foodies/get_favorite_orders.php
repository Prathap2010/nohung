<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT o.id,k.kitchenname,k.address,o.orderid
							  FROM favorite_orders AS fo 
	                          INNER JOIN orders as o ON(o.id = fo.orderid) 
						      LEFT JOIN user as k ON(k.id = o.userid)
							  WHERE fo.customerid = ".$user_id)->results();
		//echo '<pre>';print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$items = $db->pdoQuery('select GROUP_CONCAT(item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->result();

				$return_array[] = array(
					"id" => $value['id'],
					"kitchenname" => $value['kitchenname'],
					"orderid" => $value['orderid'],
					"order_items" => $items['item_name']!=''?$items['item_name']:'',
					"address" => $value['address']
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Orders not found.");
		}	

	}else{
		APIError("Login is mandatory.");
	}
}
else
{
	APIError("Token missing.");
}



