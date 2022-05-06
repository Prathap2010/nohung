<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($orderid > 0){


        $res = $db->pdoQuery("SELECT o.id,p.packagename,o.orderid,(select min(delivery_date) from orderitems where order_id = ".$orderid.") as start_date,(select max(delivery_date) from orderitems where order_id = ".$orderid.") as end_date,oi.cuisinetype
                              FROM orders AS o
                              INNER JOIN orderitems as oi ON (oi.order_id=o.id)
                              INNER JOIN packages as p ON (p.id=oi.reference_id)
						      WHERE o.id = ".$orderid."
                              GROUP BY o.id")->result();
		//echo '<pre>';print_r($res);exit;

        //Get package day list
        $day_list = $db->pdoQuery("SELECT oi.id,oi.delivery_date,oi.status,o.pickstart,o.pickend
                              FROM orderitems AS oi
                              INNER JOIN orders as o ON o.id=oi.order_id
						      WHERE oi.order_id = ".$orderid."")->results();
		//echo '<pre>';print_r($res);exit;
		if(count($day_list) > 0)
		{
			foreach ($day_list as $key => $value) {
				
                $menu_item = $db->pdoQuery('select GROUP_CONCAT(itemname ORDER BY itemname ASC SEPARATOR " + ") AS itemname FROM order_package_menu_items where orderitems_id = '.$value['id'])->result();
                
                //print_r($menu_item);exit;

                if($value['status'] == '3'){
                    $status = 'Delivered';
                }
                else if($value['status'] == '4'){
                    $status = 'Cancelled';
                }else {
                    $status = 'Upcoming';
                }

                $day_list_array[] = array(
                    "id" => $value['id'],
                    "day" => date('D', strtotime($value['delivery_date'])),
                    "menu_item" => $menu_item['itemname'],
                    "time" => $value['pickstart'].'-'.$value['pickend'],
                    "status" => $status
                );
                
				
			}
		}

		if($res['id'] > 0)
		{   

            if($res['cuisinetype'] == 0){
                $cuisinetype = 'South Indian';
            }
            else if($res['cuisinetype'] == 1){
                $cuisinetype = 'North Indian';
            }else{
                $cuisinetype = 'Other Cuisine';
            }
				
            $return_array[] = array(
                "packagename" => $res['packagename'],
                "orderid" => $res['orderid'],
                "order_dates" => date('d M',strtotime($res['start_date'])).' To '.date('d M,y',strtotime($res['end_date'])),
                "cuisinetype" => $cuisinetype,
                "day_list" => $day_list_array
            );
                
				
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



