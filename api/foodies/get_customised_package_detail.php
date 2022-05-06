<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) && $user_id > 0){

        if(isset($package_id) && $package_id > 0){

            $packageRes = $db->pdoQuery("SELECT * FROM packages as p WHERE p.id=" . $package_id)->result();

            $res = $db->pdoQuery("SELECT p.id,p.userid,p.packagename,p.cuisinetype,p.mealfor,p.mealtype,p.weeklyplantype,p.monthlyplantype,p.including_saturday,p.including_sunday,p.monthlyprice,p.weeklyprice,p.startdate,
                o.delivery_fromtime,o.delivery_totime
                                  FROM packages as p
                                  INNER JOIN order_customized_package_date_time as o ON o.userid=".$user_id." AND o.packageid=p.id
                                  WHERE p.id='".$package_id."'")->result();
            
            if(!empty($res)){
            
                $iteam_array = array();
                
                $days = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
                $days_index = array(1,2,3,4,5,6,7);

                $menus = $db->pdoQuery("SELECT w.id as weeklypackageid,w.days, 
                            (SELECT GROUP_CONCAT(wpm.itemname SEPARATOR ', ') FROM weeklypackagemenu as wpm WHERE wpm.weeklypackageid=w.id) AS item_name
                        FROM weeklypackage as w 
                        WHERE w.packageid = ".$package_id." AND days IN (".implode(",", $days_index).")" 
                    )->results();
                

                $fromtime = !empty($res) ? date("h:i", strtotime($res['delivery_fromtime'])) : "";
                $totime = !empty($res) ? date("h:i", strtotime($res['delivery_totime'])) : "";
                $price = 0;
                if(!empty($menus)){
                    foreach($menus as $val){
                        $items_array = array();
                        
                        $items = $db->pdoQuery("SELECT wpm.id,wpm.weeklypackageid,wpm.menuid,wpm.itemname,wpm.qty,wpm.price
                                FROM weeklypackagemenu as wpm
                                INNER JOIN weeklypackage as wp ON wp.id=wpm.weeklypackageid
                                WHERE wpm.weeklypackageid = ".$val['weeklypackageid']
                            )->results();

                        if(!empty($items)){
                            foreach($items as $row){
                                $cus_items = $db->pdoQuery("SELECT o.id,o.menuid,o.qty,o.itemprice
                                    FROM order_customized_package_item as o
                                    INNER JOIN weeklypackage as wp ON wp.id=o.weeklypackageid
                                    WHERE o.packageid = ".$package_id." AND o.weeklypackageid = ".$row['weeklypackageid']." AND o.menuid = ".$row['menuid']." "
                                )->result();
    
                                $row['qty'] = ($row['qty'] > 0 ? $row['qty'] : 1);
                                if(!empty($cus_items)){
                                    $qty = ($cus_items['qty'] > 0 ? ($cus_items['qty'] + $row['qty']) : 0);

                                    $items_array[] = ($qty ? $qty." " : "").$row['itemname'];

                                    $price += ($qty > 0 ? ($cus_items['itemprice']*$qty)." " : "").$cus_items['itemprice'];
                                }else{

                                    $qty = ($row['qty'] > 0 ? $row['qty'] : 0);

                                    $items_array[] = ($qty > 0 ? $qty." " : "").$row['itemname'];

                                    $price += ($row['qty'] > 0 ? ($row['price']*$row['qty'])." " : "").$row['price'];
                                }
                            }
                        }
                        $item_name = implode(" + ", $items_array);

                        $iteam_array[] = array(
                            "weekly_package_id" => $val['weeklypackageid'],
                            "days"      => $val['days'],
                            "days_name" => $days[$val['days']],
                            "item_name" => $item_name,
                            "customised_time" => (!empty($res) ? $fromtime."-".$totime : "")
                        );
                    }
                }
                
                $return_array = array(
                    "kitchen_id" => $packageRes['userid'],
                    "package_id" => $packageRes['id'],
                    "package_name" => $packageRes['packagename'],
                    "mealfor" => get_menutype($packageRes['mealfor']),
                    "mealtype" => ($packageRes['mealtype']==0 ? 'Veg' : 'Non Veg'),
                    "cuisinetype" => get_cuisinetype($packageRes['cuisinetype']),
                    "price" => number_format($price,2,'.',''),
                    "package_detail" => $iteam_array
                );
            
                APIsuccess("success",$return_array);
            }
            else
            {
                APIError("Customize package detail not found.");
            }	
    
        }else{
            APIError("Fill all required fields.");
        }
    }else{
        APIError("Login is require for add package to cart !");
    }
}
else
{
	APIError("Token missing.");
}



