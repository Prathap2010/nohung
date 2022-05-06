<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT c.id,c.kitchen_id,c.user_id,c.type,c.typeid,c.name,c.quantity,c.price,c.createddate,c.modifieddate,
            IF(c.type=2,IFNULL((SELECT image FROM mastermenu WHERE id=c.typeid),''),'') menuimage,

            IF(c.type=2,
                IFNULL((SELECT cuisinetype FROM mastermenu WHERE id=c.typeid),''),
                IFNULL((SELECT cuisinetype FROM packages WHERE id=c.typeid),'')
            ) as cuisinetype,

            CASE 
                WHEN c.type=2 THEN 'trial' 
                WHEN c.type=1 THEN 'monthly' 
                ELSE 'weekly'
            END as mealtype,

            IF(c.type=2,
                SUM(c.price * c.quantity),
                IFNULL((SELECT (IF(c.type=0,weeklyprice,monthlyprice) + IFNULL((SELECT SUM(price * IF(qty>0,qty,1)) FROM cart_package_menu_items WHERE cart_id IN (SELECT id FROM cart WHERE user_id='" . $user_id . "' GROUP BY c.type,c.typeid)),0)) FROM packages WHERE id=c.typeid),0)
            ) as totalamount,

            c.including_saturday,c.including_sunday,

            c.delivery_date,c.delivery_fromtime,c.delivery_totime,
            (SELECT delivery_date FROM cart WHERE user_id=c.user_id AND type=c.type AND typeid=c.typeid ORDER BY delivery_date ASC LIMIT 1) as fromdate,
            (SELECT delivery_date FROM cart WHERE user_id=c.user_id AND type=c.type AND typeid=c.typeid ORDER BY delivery_date DESC LIMIT 1) as todate,
            
            IFNULL(ca.address,f.address) as customeraddress,k.address as kitchen_address,c.couponcode
            FROM cart as c 
            LEFT JOIN user as k ON k.id = c.kitchen_id
            LEFT JOIN user as f ON f.id = c.user_id
            LEFT JOIN customer_address as ca ON ca.user_id = c.user_id AND is_delivery = 'y'
            WHERE c.user_id = '".$user_id."'
            GROUP BY c.type,c.typeid")->results();

        if (count($res) > 0)
		{
            $order_amount = 0;
            $cart_item_array = array();

            foreach ($res as $key => $value) {

                $order_amount += $value['totalamount'];
                
                if($value['menuimage'] != "" && file_exists(DIR_UPD.'menu/'.$value['menuimage'])){ 
                    $menuimage = SITE_UPD.'menu/'.$value['menuimage'];
                }else{
                    $menuimage = SITE_URL.'assets/image/noimage.jpg';
                }

                $price = ($value['type'] == 2) ? $value['price'] : $value['totalamount'];

				$cart_item_array[] = array(
                    "cart_id"   => $value['id'],
					"kitchen_id"=> $value['kitchen_id'],
                    "item_name" => $value['name'],
                    "menuimage" => $menuimage,
                    "quantity"  => $value['quantity'],
                    "price"     => number_format($price,2,'.',''),
                    "total_price"     => number_format($value['totalamount'],2,'.',''),
                    "mealtype"  => $value['mealtype'],
                    "typeid"    => $value['typeid'],
                    "cuisinetype"       => get_cuisinetype($value['cuisinetype']),
                    "delivery_date"     => ($value['delivery_date']=="0000-00-00" ? "" : $value['delivery_date']),
                    "delivery_fromtime" => ($value['fromdate']=="00:00:00" ? "" : $value['fromdate']),
                    "delivery_totime"   => ($value['todate']=="00:00:00" ? "" : $value['todate']),
                    "including_saturday"=> $value['including_saturday'],
                    "including_sunday"  => $value['including_sunday'],
                    "createddate"       => $value['createddate'],
				);
			}

            $offerRes = $db->pdoQuery("SELECT id,offercode,discounttype,discount,startdate,enddate,starttime,endtime,usagelimit,
                                    IFNULL((SELECT count(id) FROM orders WHERE couponcode=offercode),0) as countusage
                                FROM offer
                                WHERE (userid=0 OR userid='" . $res[0]['kitchen_id'] . "') AND offercode='" . $res[0]['couponcode'] . "'
                                ")->result();
                                
            $my_address = $db->pdoQuery("SELECT * FROM customer_address WHERE is_delivery='y' AND user_id='".$user_id."'")->result();

            $setting = $db->pdoQuery("SELECT taxonorder,delivery_charge_per_km,mapapikey FROM sitesetting WHERE id=1")->result();

            $GOOGLE_MAP_API_KEY = $setting['mapapikey'];
            
            $distance = get_duration_between_two_places($GOOGLE_MAP_API_KEY, $res[0]['customeraddress'], $res[0]['kitchen_address'],'distance',1);
            
            $tax_amount = $order_amount * $setting['taxonorder'] / 100;
            $delivery_charge = ($setting['delivery_charge_per_km'] * $distance);

            $sub_total = number_format($order_amount + $tax_amount + $delivery_charge, 2, '.', '');

            $discounttype = $offerRes['discounttype'];

            $coupon_discount = 0;
            if(!empty($offerRes)){
                if ($offerRes['usagelimit'] == 0 || $offerRes['countusage'] < $offerRes['usagelimit']) {

                    $starttime = date('Y-m-d H:i:s', strtotime($offerRes['startdate'] . " " . $offerRes['starttime']));
                    $endtime = date('Y-m-d H:i:s', strtotime($offerRes['enddate'] . " " . $offerRes['endtime']));
                    $currenttime = date("Y-m-d H:i:s");

                    if ($starttime <= $currenttime && $endtime >= $currenttime) {
                        if ($discounttype == 0) {
                            $coupon_discount = $sub_total * $offerRes['discount'] / 100;
                        } else {
                            $coupon_discount = $offerRes['discount'];
                        }
                    }
                }
            }

            $sub_total = $sub_total - $coupon_discount;

            $return_array = array(
                "cart_items"        => $cart_item_array,
                "cart_total"        => number_format($order_amount, 2, '.', ''),
                "tax_amount"        => number_format($tax_amount,2,'.',''),
                "delivery_charge"   => number_format($delivery_charge,2,'.',''),
                "coupon_discount"   => number_format($coupon_discount, 2, '.', ''),
                "sub_total"         => number_format($sub_total,2,'.',''),
                "my_location"       => array(
                    "address"       => !empty($my_address) ? $my_address['address'] : "",
                    "latitude"      => !empty($my_address) ? $my_address['latitude'] : "",
                    "longitude"     => !empty($my_address) ? $my_address['longitude'] : ""
                ),
            );

			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Item not found in cart.");
		}	

	}else{
		APIError("Login is mandatory.");
	}
}
else
{
	APIError("Token missing.");
}



