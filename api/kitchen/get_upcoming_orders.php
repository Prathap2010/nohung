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
                $where .= " AND oi.delivery_date >= '".$res['fromdate']."'";
            }
            if($res['todate'] != "0000-00-00"){
                $where .= " AND oi.delivery_date <= '".$res['todate']."'";
            }
            if($res['order_number'] != ""){
                $where .= " AND o.orderid LIKE '%".$res['order_number']."%'";
            }
        }

		$res = $db->pdoQuery("SELECT o.id,oi.id as orderitemsid,c.kitchenname,c.mobilenumber,o.deliveryaddress,o.orderid,o.netamount,o.status,
                                oi.delivery_date,o.ordertype
							  FROM orders AS o
                              INNER JOIN orderitems as oi ON oi.order_id = o.id 
						      LEFT JOIN user as c ON(c.id = o.customerid)
							  WHERE ((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2,5))) AND oi.delivery_date > CURDATE() AND  o.userid = '".$kitchen_id."'".$where."
                              GROUP BY oi.order_id,oi.delivery_date
							  ORDER BY oi.order_id,oi.delivery_date DESC
                            ")->results();
		
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

				}else{

					$items = $db->pdoQuery('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->result();

					$item_name = $items['item_name']!=''?$items['item_name']:'';
				}

				$return_array[] = array(
					"customer_name" => $value['kitchenname'],
                    "customer_mobilenumber" => $value['mobilenumber'],
					"order_number" => $value['orderid'],
                    "order_date" => date("M dS, Y", strtotime($value['delivery_date'])),
					"order_items" => $item_name,
					"delivery_address" => $value['deliveryaddress']
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



