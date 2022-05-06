<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($userid > 0){

		$whr = '';
		if($date_from != '' && $date_to != ''){

			$date_from = date('Y-m-d',strtotime($date_from));
			$date_to = date('Y-m-d',strtotime($date_to));
			$whr .= " AND o.createddate BETWEEN '".$date_from."' AND '".$date_to."'";

		}

		if($customerid != ''){
			$whr .= " AND c.kitchenid = '".$customerid."'";
		}

		if($status != ''){
			if($status == 'pending'){
				$whr .= " AND o.status IN ('4','5')";	
			}else if($status == 'paid'){
				$whr .= " AND o.status IN ('6')";	
			}
		}

		$res = $db->pdoQuery("SELECT o.orderid,o.pickstart,o.deliverycharge,o.status,c.kitchenname,o.createddate,c.kitchenid
	                          FROM orders as o 
						      LEFT JOIN user as c ON(c.id = o.customerid)
							  WHERE o.status IN ('4','5','6') and o.riderid = ".$userid." 
							  $whr
							  ORDER BY o.id DESC")->results();
		//print_r($res);exit;
		if(count($res) > 0)
		{	
			$current_orders = $expected_earnings = $cancelled = 0;
			foreach ($res as $value) {

				$current_orders += 1;
				$expected_earnings += $value['deliverycharge'];
				$cancelled =  $db->pdoQuery("SELECT count(id) as total
											 FROM orders 
											 WHERE status = '7' and riderid = ".$userid."")->result();

				$return_array[] = array(
					"orderid"         => $value['orderid'],
					"date"            => date('Y-m-d',strtotime($value['createddate'])),
					"time"            => $value['pickstart'],
					"deliverycharge"  => $value['deliverycharge'],
					"status"          => $value['status'] == 6 ? 'Paid' : 'Pending',
					"customerid"      => $value['kitchenid'],
					"order_by"        => $value['kitchenname']
				);
			}

			$global_array['expected_earnings'] = $expected_earnings;
			$global_array['current_orders'] = $current_orders;
			$global_array['cancelled'] = $cancelled['total'];
			
			APIsuccess("success",$return_array,'','','',$global_array);
		}
		else
		{
			APIError("Order history not found.");
		}

	}else{
		APIError("Fill all required fields.");
	}	
}
else
{
	APIError("Token missing.");
}



