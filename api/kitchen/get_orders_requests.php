<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0){
        
        $res = $db->pdoQuery("SELECT * FROM kitchen_order_filters WHERE kitchen_id = '".$kitchen_id."'")->result();

        $where = "";
        if(!empty($res)){
            if($res['fromdate'] != "0000-00-00"){
                $where .= " AND o.orderdate >= '".$res['fromdate']."'";
            }
            if($res['todate'] != "0000-00-00"){
                $where .= " AND o.orderdate <= '".$res['todate']."'";
            }
            if($res['order_number'] != ""){
                $where .= " AND o.orderid LIKE '%".$res['order_number']."%'";
            }
        }
		$res = $db->pdoQuery("SELECT o.id,o.customer_name,o.customer_mobileno,c.profile_image as customer_image,o.deliveryaddress,o.orderid,o.netamount,o.status,
                                o.orderdate,o.ordertype,o.packagetype
							  FROM orders AS o
                              LEFT JOIN user as c ON(c.id = o.customerid)
							  WHERE o.ordertype='package' AND o.status=0 AND o.userid = '".$kitchen_id."'".$where."
                              ORDER BY o.id DESC
                            ")->results();
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                $trial_order = $weeklyplan = $monthlyplan = "";

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
    
                if($value['customer_image'] != "" && file_exists(DIR_UPD.'profile/'.$value['customer_image'])){ 
                    $customer_image = SITE_UPD.'profile/'.$value['customer_image'];
                }else{
                    $customer_image = SITE_URL.'assets/image/userprofile/noimage.png';
                }
                $return_array[] = array(
                    "order_id" => $value['id'],
                    "customer_name" => $value['customer_name'],
                    "customer_mobilenumber" => $value['customer_mobileno'],
                    "customer_image" => $customer_image,
                    "order_number" => $value['orderid'],
                    "order_date" => date("M dS, Y", strtotime($value['orderdate'])),
                    /* "order_items" => $item_name, */
                    "weekly_plan" => $weeklyplan,
                    "monthly_plan" => $monthlyplan,
                    "delivery_address" => $value['deliveryaddress'],
                    "total_bill" => number_format($value['netamount'],2,'.',''),
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



