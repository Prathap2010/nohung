<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT c.id,c.kitchen_id,c.user_id,c.type,c.typeid,c.name,c.quantity,c.price,c.createddate,c.modifieddate,
            IF(c.type=2,IFNULL((SELECT image FROM mastermenu WHERE id=c.typeid),''),'') menuimage,

            IF(c.type=2,
                IFNULL((SELECT cuisinetype FROM mastermenu WHERE id=c.typeid),''),
                IFNULL((SELECT cuisinetype FROM packages WHERE id=c.typeid),'')
            ) as cuisinetype,

            c.including_saturday,c.including_sunday,

            c.delivery_date,c.delivery_fromtime,c.delivery_totime
        
            FROM cart as c WHERE c.user_id = '".$user_id."'")->results();

        if (count($res) > 0)
		{
            foreach ($res as $key => $value) {
				
				$return_array[] = array(
                    "cart_id"   => $value['id'],
					"kitchen_id"=> $value['kitchen_id'],
                    "item_name" => $value['name'],
                    "menuimage" => $value['menuimage'],
                    "quantity"  => $value['quantity'],
                    "price"     => $value['price'],
                    "mealtype"  => $value['type'],
                    "cuisinetype"       => $value['cuisinetype'],
                    "delivery_date"     => ($value['delivery_date']=="0000-00-00" ? "" : $value['delivery_date']),
                    "delivery_fromtime" => ($value['delivery_fromtime']=="00:00:00" ? "" : $value['delivery_fromtime']),
                    "delivery_totime"   => ($value['delivery_totime']=="00:00:00" ? "" : $value['delivery_totime']),
                    "including_saturday"=> $value['including_saturday'],
                    "including_sunday"  => $value['including_sunday'],
                    "createddate"       => $value['createddate'],
				);
			}
			
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Item not found in cart.");
		}	

	}else{
		APIError("Login is mandatory.");
	}
}
else
{
	APIError("Token missing.");
}



