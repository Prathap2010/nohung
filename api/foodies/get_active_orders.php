<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT o.id,oi.id as orderitemsid,k.kitchenname,k.address,o.orderid,o.ordertype,
								(SELECT delivery_date FROM orderitems WHERE order_id=o.id ORDER BY delivery_date ASC LIMIT 1) as fromdate,
                                (SELECT delivery_date FROM orderitems WHERE order_id=o.id ORDER BY delivery_date DESC LIMIT 1) as todate
							  FROM orders AS o
							  INNER JOIN orderitems as oi ON oi.order_id = o.id 
						      LEFT JOIN user as k ON(k.id = o.userid)
							  WHERE ((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2,5))) AND oi.delivery_date <= CURDATE() AND o.customerid = ".$user_id. "
							  
							  GROUP BY oi.order_id,oi.delivery_date
							  ORDER BY o.id DESC
							")->results();
		// echo '<pre>';print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				if($value['ordertype'] == 'package'){
					$menu_item = $db->pdoQuery("SELECT id,menuid,itemname,qty,price FROM order_package_menu_items WHERE orderitems_id = '".$value['orderitemsid']."'")->results();

					$item_name = array();
					if(count($menu_item) > 0){
						foreach($menu_item as $item){
							// $item_name[] = ($item['qty'] > 0 ? $item['qty']." " : "").$item['itemname']; 
							$item_name[] = $item['itemname']; 
						}
					}
					$item_name = implode(" + ", $item_name);

					$itemRes = $db->pdoQuery("SELECT id,mealplan,reference_id, 
												(SELECT (CASE 
													WHEN mealfor=0 THEN 'Breakfast' 
													WHEN mealfor=1 THEN 'Lunch' 
													ELSE 'Dinner'
												END) FROM packages WHERE id=reference_id) as plan
										FROM orderitems
										WHERE id = '" . $value['orderitemsid'] . "'")->result();

					
					$meal_type = $itemRes["plan"];
				}else{

					$items = $db->pdoQuery('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->result();

					$item_name = $items['item_name']!=''?$items['item_name']:'';

					$meal_type = "";
				}
                    
				
				if($value['fromdate'] == $value['todate']){
                    $orderfrom = date("d M, Y", strtotime($value['fromdate']));
                }else{
                    $orderfrom = date("d M", strtotime($value['fromdate'])).' - '.date("d M, Y", strtotime($value['todate']));
                }

				

				$return_array[] = array(
					"id" => $value['id'],
					"kitchenname" => $value['kitchenname'],
					"orderid" => $value['orderid'],
					"orderfrom" => $orderfrom,
					"order_items" => $item_name,
					"address" => $value['address'],
					"meal_plan"	=> $value['ordertype'],
					"meal_type"	=> $meal_type
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