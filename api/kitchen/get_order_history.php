<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0){

        $res = $db->pdoQuery("SELECT * FROM kitchen_order_filters WHERE kitchen_id = '".$kitchen_id."'")->result();

        $where_ord = $where_item = "";
        if(!empty($res)){
            if($res['fromdate'] != "0000-00-00"){
                $where_ord .= " AND o.orderdate >= '".$res['fromdate']."'";
                $where_item .= " AND oi.delivery_date >= '".$res['fromdate']."'";
            }
            if($res['todate'] != "0000-00-00"){
                $where_ord .= " AND o.orderdate <= '".$res['todate']."'";
                $where_item .= " AND oi.delivery_date <= '".$res['todate']."'";
            }
            if($res['order_number'] != ""){
                $where_ord .= " AND o.orderid LIKE '%".$res['order_number']."%'";
                $where_item .= " AND o.orderid LIKE '%".$res['order_number']."%'";
            }
        }
        
        $res = $db->pdoQuery("SELECT o.id
                              FROM orders AS o
                              LEFT JOIN user as c ON(c.id = o.customerid)
                              WHERE o.status=0 AND o.userid = '".$kitchen_id."'".$where_ord."
                            ")->results();

        $pending_orders = count($res);

        $res = $db->pdoQuery("SELECT o.id
                              FROM orders AS o
                              INNER JOIN orderitems as oi ON oi.order_id = o.id 
						      LEFT JOIN user as c ON(c.id = o.customerid)
							  WHERE ((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2))) AND oi.delivery_date = CURDATE() AND  o.userid = '".$kitchen_id."'".$where_item."
                              GROUP BY oi.delivery_date
                            ")->results();

        $active_orders = count($res);

        $res = $db->pdoQuery("SELECT oi.id
                              FROM orderitems as oi
                              INNER JOIN orders AS o ON o.id = oi.order_id
							  WHERE ((o.ordertype='trial' AND o.status=7) OR (o.ordertype='package' AND o.status=1 AND oi.status=4)) AND o.userid = '".$kitchen_id."'".$where_item."
                              GROUP BY oi.delivery_date
                            ")->results();

        $cancelled_orders = count($res);

        $res = $db->pdoQuery("SELECT SUM(netamount) as total
                              FROM orders AS o
							  WHERE o.userid = ".$kitchen_id."".$where_ord."
                            ")->result();

        $total_sales = number_format($res['total'],2,'.','');

        $tomorrow_date = date("Y-m-d", strtotime("+ 1 day"));

        $res = $db->pdoQuery("SELECT SUM(netamount) as total
                              FROM orders AS o
							  WHERE o.userid = ".$kitchen_id." AND (o.orderdate = '".$tomorrow_date."')
                            ")->result();

        $projected_sales_tomorrow = number_format($res['total'],2,'.','');

        $return_array['booked'] = $pending_orders;
        $return_array['paid'] = $active_orders;
        $return_array['cancelled'] = $cancelled_orders;
        $return_array['total_sales'] = $total_sales;
        $return_array['projected_sales_tomorrow'] = $projected_sales_tomorrow;
        $return_array['order_history'] = array();

		$res = $db->pdoQuery("SELECT o.id,c.kitchenname,c.mobilenumber,o.deliveryaddress,o.orderid,o.netamount,o.status,
                                o.orderdate,o.ordertype,o.packagetype
							  FROM orders AS o
                              LEFT JOIN user as c ON(c.id = o.customerid)
							  WHERE o.userid = '".$kitchen_id."'".$where_ord."
                              ORDER BY o.id DESC
                            ")->results();
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                $trial_order = $weeklyplan = $monthlyplan = "";
                $packagetype = $value['packagetype'];

                if($value['ordertype'] == "trial"){
                    $items = $db->pdoQuery('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->result();

                    $trial_order = $items['item_name']!=''?$items['item_name']:'';
                    
                    $packagetype = "";
                }else{

                    $order_item = $db->pdoQuery("SELECT id,mealplan,reference_id, 
                                                    (SELECT (CASE 
                                                                WHEN mealfor=0 THEN 'Breakfast' 
                                                                WHEN mealfor=1 THEN 'Lunch' 
                                                                ELSE 'Dinner'
                                                            END) FROM packages WHERE id=reference_id) as plan 
                                                FROM orderitems WHERE order_id = '".$value['id']."' 
                                                GROUP BY mealplan,reference_id
                                            ")->results();
    
                    $order_item_arr = !empty($order_item) ? array_column($order_item, "mealplan") : array();
                    
                    $keys = array_keys($order_item_arr, "0");
    
                    if($keys != "" && !empty($keys)){
                        foreach($keys as $key){
                            if(isset($order_item[$key])){
                                $weeklyplan .= $order_item[$key]['plan'].", ";
                            }
                        }
                    }
                    $keys = array_keys($order_item_arr, "1");
    
                    if($keys != "" && !empty($keys)){
                        foreach($keys as $key){
                            if(isset($order_item[$key])){
                                $monthlyplan .= $order_item[$key]['plan'].", ";
                            }
                        }
                    }
                    if($weeklyplan != ""){
                        $weeklyplan = substr($weeklyplan, 0, -2);
                    }
                    if($monthlyplan != ""){
                        $monthlyplan = substr($monthlyplan, 0, -2);
                    }
                }

				$return_array['order_history'][] = array(
                    "order_id" => $value['id'],
                    "order_type" => $value['ordertype'],
                    "package_type" => $packagetype,
					"customer_name" => $value['kitchenname'],
                    "customer_mobilenumber" => $value['mobilenumber'],
					"order_number" => $value['orderid'],
                    "order_date" => date("M dS, Y", strtotime($value['orderdate'])),
					// "order_items" => $item_name,
                    "weekly_plan" => $weeklyplan,
                    "monthly_plan" => $monthlyplan,
                    "trial_order" => $trial_order,
                    "delivery_address" => $value['deliveryaddress'],
                    "total_bill" => number_format($value['netamount'],2,'.',''),
				);
			}
		}
        
        APIsuccess("success",$return_array);

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



