<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT o.id,k.kitchenname,o.orderid,
                                (SELECT delivery_date FROM orderitems WHERE order_id=o.id ORDER BY delivery_date ASC LIMIT 1) as fromdate,
                                (SELECT delivery_date FROM orderitems WHERE order_id=o.id ORDER BY delivery_date DESC LIMIT 1) as todate,
                                o.netamount,o.status,o.ordertype,o.packagetype
							  FROM orders AS o
						      LEFT JOIN user as k ON(k.id = o.userid)
							  WHERE o.customerid = ".$user_id)->results();
		//echo '<pre>';print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				// $items = $db->pdoQuery('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->result();
                if($value['fromdate'] == $value['todate']){
                    $orderfrom = date("d M, Y", strtotime($value['fromdate']));
                }else{
                    $orderfrom = date("d", strtotime($value['fromdate'])).' - '.date("d M, Y", strtotime($value['todate']));
                }

				$status = "Pending";
				if($value['ordertype'] == 'trial'){
					if($value['status']==1){
						$status = "Active";
					}else if ($value['status']==2){
						$status = "Reject";
					}else if ($value['status']==3){
						$status = "Ready to pick";
					}else if ($value['status']==4){
						$status = "Assign to rider";
					}else if ($value['status']==5){
						$status = "Start delivery";
					}else if ($value['status']==6){
						$status = "Delivered";
					}else if ($value['status']==7){
						$status = "Cancelled";
					}
					$order = "Trial Meal";
				}else{
					if($value['status']==1){
						$status = "Active";
					}else if ($value['status']==2){
						$status = "Reject";
					}

					$orderitems = $db->pdoQuery('select id,mealplan,(select mealfor FROM packages where id=reference_id) as mealfor FROM orderitems where order_id = '.$value['id'].' AND mealplan!=2 GROUP BY mealplan')->results();

					$order = "";

					if(!empty($orderitems)){
						foreach($orderitems as $val){
							if($val['mealplan'] == '0'){
								$order .= "Weekly ".get_menutype($val['mealfor']).", ";
							}else if($val['mealplan'] == '1'){
								$order .= "Monthly ".get_menutype($val['mealfor']).", ";
							}		
						}
					}
					$order = substr($order, 0, -2);
					
				}

				$return_array[] = array(
					"order_id" => $value['id'],
					"kitchenname" => $value['kitchenname'],
					"ordernumber" => $value['orderid'],
					"orderfrom" => $orderfrom,
                    "status" => $status,
					"order_of" => $order,
                    "totalbill" => number_format($value['netamount'],2,'.',''),
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



