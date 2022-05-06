<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0){

		$res = $db->pdoQuery("SELECT o.id,oi.id as orderitemsid,c.kitchenname,c.mobilenumber,o.deliveryaddress,o.orderid,o.netamount,o.status,
                                o.orderdate,o.ordertype,oi.delivery_fromtime
							  FROM orders AS o
                              INNER JOIN orderitems as oi ON oi.order_id = o.id 
						      LEFT JOIN user as c ON (c.id = o.customerid)
							  WHERE ((o.ordertype='trial' AND o.status=5) OR (o.ordertype='package' AND o.status=1 AND oi.status=2)) AND  o.userid = ".$kitchen_id."

                              GROUP BY oi.delivery_date
                            ")->results();
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"order_id" => $value['id'],
                    "orderitems_id" => $value['orderitemsid'],
                    "order_number" => $value['orderid'],
                    "time" => date("H:i A", strtotime($value['delivery_fromtime'])),
					"order_by" => $value['kitchenname'],
					"delivery_address" => $value['deliveryaddress'],
					"total_bill" => $value['netamount'],
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Orders not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



