<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0){

        $res = $db->pdoQuery("SELECT o.id
                              FROM orders AS o
                              INNER JOIN orderitems as oi ON oi.order_id = o.id
                              LEFT JOIN user as c ON(c.id = o.customerid)
                              WHERE ((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2,5))) AND oi.delivery_date <= CURDATE() AND  o.userid = ".$kitchen_id."
                              GROUP BY oi.order_id,oi.delivery_date
                            ")->results();

        $active_orders = count($res);

        $res = $db->pdoQuery("SELECT oi.id
                              FROM orderitems as oi
                              INNER JOIN orders AS o ON o.id  = oi.order_id
                              LEFT JOIN user as c ON(c.id = o.customerid)
                              WHERE ((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2,5))) AND oi.delivery_date > CURDATE() AND  o.userid = ".$kitchen_id."
                              GROUP BY oi.order_id,oi.delivery_date
                            ")->results();

        $upcoming_orders = count($res);

        $res = $db->pdoQuery("SELECT o.id
                              FROM orders AS o
                              LEFT JOIN user as c ON(c.id = o.customerid)
							                WHERE o.status=0 AND o.userid = ".$kitchen_id."
                            ")->results();

        $pending_orders = count($res);

        $res = $db->pdoQuery("SELECT oi.id
                              FROM orderitems as oi
                              INNER JOIN orders AS o ON o.id = oi.order_id
                              WHERE ((o.ordertype='trial' AND o.status=6) OR (o.ordertype='package' AND o.status=1 AND oi.status=3)) AND o.userid = ".$kitchen_id."
                              GROUP BY oi.order_id,oi.delivery_date
                            ")->results();

        $completed_orders = count($res);

        $res = $db->pdoQuery("SELECT oi.id
                              FROM orderitems as oi
                              INNER JOIN orders AS o ON o.id = oi.order_id
							  WHERE ((o.ordertype='trial' AND o.status=5) OR (o.ordertype='package' AND o.status=1 AND oi.status=2)) AND o.userid = ".$kitchen_id."
                              GROUP BY oi.delivery_date
                            ")->results();

        $active_deliveries = count($res);

        $res = $db->pdoQuery("SELECT oi.id
                              FROM orderitems as oi
                              INNER JOIN orders AS o ON o.id = oi.order_id
							  WHERE ((o.ordertype='trial' AND o.status=1) OR (o.ordertype='package' AND o.status=1 AND oi.status=5)) AND o.userid = ".$kitchen_id."
                              GROUP BY oi.delivery_date
                            ")->results();

        $preparing = count($res);
        
        $res = $db->pdoQuery("SELECT oi.id
                              FROM orderitems as oi
                              INNER JOIN orders AS o ON o.id = oi.order_id
							  WHERE ((o.ordertype='trial' AND o.status=3) OR (o.ordertype='package' AND o.status=1 AND oi.status=0)) AND o.userid = ".$kitchen_id."
                              GROUP BY oi.delivery_date
                            ")->results();

        $ready = count($res);

        $res = $db->pdoQuery("SELECT oi.id
                              FROM orderitems as oi
                              INNER JOIN orders AS o ON o.id = oi.order_id
							  WHERE ((o.ordertype='trial' AND o.status=4) OR (o.ordertype='package' AND o.status=1 AND oi.status=1)) AND o.userid = ".$kitchen_id."
                              GROUP BY oi.delivery_date
                            ")->results();

        $out_for_delivery = count($res);

        $user = $db->pdoQuery("SELECT kitchenname,address,profile_image FROM user as k WHERE k.id = ".$kitchen_id)->result();

        if ($user['profile_image'] != "" && file_exists(DIR_UPD . 'profile/'.$user['profile_image'])) {
          $profile_image = SITE_UPD . 'profile/' . $user['profile_image'];
        } else {
          $profile_image = SITE_URL . 'assets/image/userprofile/noimage.png';
        }
        // print_r($upcoming_orders); exit;
        $return_array = array(
            "kitchen_name"      => $user['kitchenname'],
            "kitchen_address"   => $user['address'],
            "profile_image"   => $profile_image,
            "active_orders"     => $active_orders,
            "upcoming_orders"   => $upcoming_orders,
            "pending_orders"    => $pending_orders,
            "completed_orders"  => $completed_orders,
            "active_deliveries" => $active_deliveries,
            "preparing"         => $preparing,
            "ready"             => $ready,
            "out_for_delivery"  => $out_for_delivery,
            "profit"            => 2950,
            "loss"              => 485,
        );

		APIsuccess("success",$return_array);

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



