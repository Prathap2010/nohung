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

		$res = $db->pdoQuery("SELECT o.id,c.kitchenname,c.mobilenumber,o.deliveryaddress,o.orderid,o.netamount,o.status,
                                o.orderdate,o.ordertype,o.packagetype
							  FROM orders AS o
                              LEFT JOIN user as c ON(c.id = o.customerid)
							  WHERE o.ordertype='trial' AND o.status IN (0,1,3,4,5) AND o.userid = '".$kitchen_id."'".$where."
                              ORDER BY o.id DESC
							")->results();
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                $items = $db->pdoQuery('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->result();

                $item_name = $items['item_name']!=''?$items['item_name']:'';

				if($value['status']==1){
					$status = "Order in Preparation";
				}else if ($value['status']==3){
					$status = "Ready to pick";
				}else if ($value['status']==4){
					$status = "Assign to rider";
				}else if ($value['status']==5){
					$status = "Start delivery";
				}else if ($value['status']==0){
					$status = "Pending";
				}

				$return_array[] = array(
                    "order_id" => $value['id'],
					"customer_name" => $value['kitchenname'],
                    "customer_mobilenumber" => $value['mobilenumber'],
					"order_number" => $value['orderid'],
                    "order_date" => date("M dS, Y", strtotime($value['orderdate'])),
					"order_items" => $item_name,
					"status" => $status,
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



