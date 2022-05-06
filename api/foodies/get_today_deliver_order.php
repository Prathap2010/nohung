<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT o.id,oi.id as orderitemsid,o.ordertype,o.packagetype,o.customer_name,o.customer_mobileno,
		o.riderid,
                                IFNULL(rider.kitchenname,'') as rider_name,
                                IFNULL(rider.mobilenumber,'') as rider_mobileno,
                                
                                IFNULL(kitchen.kitchenname,'') as kitchen_name,
                                IFNULL(kitchen.mobilenumber,'') as kitchen_mobileno,

                                CAST(IFNULL((SELECT AVG(rf.ratting) FROM riderfeedback as rf WHERE rf.riderid=o.riderid),0) AS DECIMAL(2,1)) as rider_rating, 
                                IFNULL((SELECT count(rf.id) FROM riderfeedback as rf WHERE rf.riderid=o.riderid),0) as rider_review, 

                                o.track_rider_latitude,o.track_rider_longitude
							  FROM orderitems as oi
                              INNER JOIN orders AS o ON o.id = oi.order_id
							  LEFT JOIN user as rider ON rider.id = o.riderid
							  LEFT JOIN user as kitchen ON kitchen.id = o.userid
							  WHERE ((o.ordertype='trial' AND o.status IN (5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (2))) AND o.customerid = ".$user_id)->result();
		
		//echo '<pre>';print_r($res);exit;
		
		if(!empty($res))
		{
            // $meal = array();
			
                
            $meal = $db->pdoQuery("SELECT id,mealplan,reference_id,delivery_date,delivery_fromtime,
                                                IFNULL((SELECT (CASE 
                                                    WHEN mealfor=0 THEN 'Breakfast' 
                                                    WHEN mealfor=1 THEN 'Lunch' 
                                                    ELSE 'Dinner'
                                                END) FROM packages WHERE id=reference_id),'') as plan
                                    
                                    FROM orderitems
                                    WHERE id = '".$res['orderitemsid']."'")->result();

            if($res['ordertype'] == "package"){

                $items = $db->pdoQuery('SELECT GROUP_CONCAT(DISTINCT itemname ORDER BY itemname ASC SEPARATOR " + ") AS itemname FROM order_package_menu_items where orderitems_id = '.$res['orderitemsid'])->result();

                $meal['item_name'] = $items['itemname'];


                // Current date and time
                $currentdatetime = date("Y-m-d H:i:s");
                $delivery_datetime = date("Y-m-d H:i:s", strtotime($meal['delivery_date']." ".$meal['delivery_fromtime']));
                $timestamp = strtotime($delivery_datetime);
                $time = $timestamp - (1 * 60 * 60);
                $delivery_datetime = date("Y-m-d H:i:s", $time);
                
                $meal['iscancel'] = 0;
                if(strtotime($currentdatetime) < strtotime($delivery_datetime)){
                    $meal['iscancel'] = 1;
                
                }
                $meal['cancel_datetime'] = $delivery_datetime;
                $meal['cancel_time'] = date("H:i:s", $time);

            }else{
                $trialmenu = $db->pdoQuery('SELECT GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$res['id'])->result();
                        
                $meal['item_name'] = $trialmenu['item_name'];			
            }
            $return = $meal;
            
            
            $return_array[] = array(
                "orderitemsid"	=> $res['orderitemsid'],
                "ordertype"		=> $res['ordertype'],
                "packagetype"	=> $res['packagetype'],
                "kitchen_name"	=> $res['kitchen_name'],
                "kitchen_mobileno"	=> $res['kitchen_mobileno'],
                "rider_name"	=> $res['rider_name'],
                "rider_mobileno"	=> $res['rider_mobileno'],
                "rider_rating"	=> $res['rider_rating'],
                "rider_review"	=> $res['rider_review'],
                "track_rider_latitude"	=> $res['track_rider_latitude'],
                "track_rider_longitude"	=> $res['track_rider_longitude'],
                "meal"			=> $return
            );
               
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Order not found.", $return_array);
		}	

	}else{
		APIError("Fill all required fields.");
	}
	
}
else
{
	APIError("Token missing.");
}



