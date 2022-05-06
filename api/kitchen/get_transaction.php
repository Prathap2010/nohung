<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0){

        $res = $db->pdoQuery("SELECT IFNULL(SUM(oi.total_amount),0) as total
                              FROM orderitems AS oi
							  INNER JOIN orders AS o ON o.id=oi.order_id 
							  WHERE ((o.ordertype='trial' AND o.status=6) OR (o.ordertype='package' AND oi.status=3)) AND o.userid = ".$kitchen_id."
                            ")->result();

		if(!empty($res)){
			$total_earning = number_format($res['total'],2,'.','');
		}else{
			$total_earning = 0;
		}

		$res = $db->pdoQuery("SELECT IFNULL(SUM(kwp.amount),0) as total
                              FROM kitchenwithdrawpayment as kwp
							  WHERE kwp.kitchen_id = ".$kitchen_id."
                            ")->result();

		if(!empty($res)){
			$total_withdraw = number_format($res['total'],2,'.','');
		}else{
			$total_withdraw = 0;
		}

		$wallet_balance = $total_earning - $total_withdraw;
			
		$return_array['current_balance'] = number_format($wallet_balance,2,'.','');
        $return_array['total_earning'] = $total_earning;
        $return_array['transaction'] = array();

		$res = $db->pdoQuery("SELECT o.id,c.kitchenname,c.mobilenumber,tr.order_number,tr.amount,tr.createddate
							  FROM orders AS o
                              INNER JOIN transaction as tr ON tr.order_id=o.id AND tr.payment_type='order' AND tr.payment_method='payumoney'
                              LEFT JOIN user as c ON(c.id = o.customerid)
							  WHERE o.userid = ".$kitchen_id."
                              GROUP BY tr.createddate DESC
                            ")->results();
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array['transaction'][] = array(
					"customer_name" => $value['kitchenname'],
                    "customer_mobilenumber" => $value['mobilenumber'],
					"order_number" => $value['order_number'],
                    "transaction_date" => date("D, d M Y", strtotime($value['createddate'])),
					"amount" => number_format($value['amount'],2,'.','')
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



