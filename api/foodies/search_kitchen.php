<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if($customer_address==""){
        APIError("Select customer location.");    
    }else{
        
        if(isset($customer_id) && $search_location_or_kitchen!=""){
            $checkKeyword =  $db->count("searchhistory",array("userid"=>$customer_id,"keyword"=>$search_location_or_kitchen));
    
            if($checkKeyword == 0 && $search_location_or_kitchen != ""){
    
                $data_array = array(
                    "userid"  => $customer_id,
                    "keyword" => $search_location_or_kitchen,
                );
            
                $db->insert("searchhistory",$data_array);
            }
        }
        $res = $db->pdoQuery("SELECT mapapikey,radius_in_km FROM sitesetting WHERE id=1")->result();
        $GOOGLE_MAP_API_KEY = $res['mapapikey'];
        $RADIUS_IN_KM = $res['radius_in_km'];
    
        $where = " WHERE (temp.kitchenname LIKE '%".$search_location_or_kitchen."%' OR 
                        temp.address LIKE '%".$search_location_or_kitchen."%' OR
                        temp.provincename LIKE '%".$search_location_or_kitchen."%' OR 
                        temp.cityname LIKE '%".$search_location_or_kitchen."%' OR 
                        temp.pincode LIKE '%".$search_location_or_kitchen."%'                    
                    )";
        
        $sel_pkg = "IF(pkg.weeklyplantype=1,0,'') as mealplan,
                    pkg.weeklyprice as price";
        
        if($mealtype != ""){
            if($mealtype != 2){ 
                if($mealtype==0){
                    $meal_type = "Veg";
                }else{
                    $meal_type = "Non Veg";
                }
                $where .= " AND (FIND_IN_SET('".$meal_type."', temp.mealtype)>0)";
            }else{
                $where .= " AND (FIND_IN_SET('Veg', temp.mealtype)>0 OR FIND_IN_SET('Non Veg', temp.mealtype)>0)";
            }
        }
    
        if($mealfor != ""){
            if($mealfor == 0){ 
                $meal_for = "Breakfast";
            }elseif($mealfor == 1){ 
                $meal_for = "Lunch";    
            }else{
                $meal_for = "Dinner";
            }
            $where .= " AND (FIND_IN_SET('".$meal_for."', temp.mealtype)>0)";
        }
        if($cuisinetype != ""){
            if($cuisinetype == 0){ 
                $cuisine_type = "South Indian Meals";    
            }elseif($cuisinetype == 1){ 
                $cuisine_type = "North Indian Meals";
            }else{
                $cuisine_type = "Diet Meals";
            }
            $where .= " AND (FIND_IN_SET('".$cuisine_type."', temp.foodtype)>0)";
        }
        $wh_plan = "";
        if($mealplan!=""){
            if($mealplan==0){
                $wh_plan .= " AND IF((SELECT count(id) FROM packages WHERE userid=u.id AND weeklyplantype=1)>0, 1, 0)=1";
            }else if($mealplan==1){
                $wh_plan .= " AND IF((SELECT count(id) FROM packages WHERE userid=u.id AND monthlyplantype=1)>0, 1, 0)=1";
            }else{
                $wh_plan .= " AND IF((SELECT count(id) FROM mastermenu WHERE userid=u.id)>0, 1, 0)=1";
            }
        }
        $wh_price = "";
        if($min_price != "" && $min_price > 0){
            $wh_price .= " AND 
                (IF((SELECT count(id) FROM mastermenu WHERE userid=u.id AND itemprice >= '".$min_price."')>0, 1, 0)=1 OR 
                IF((SELECT count(id) FROM packages WHERE userid=u.id AND weeklyprice >= '".$min_price."')>0, 1, 0)=1)";
        }
        if($max_price != "" && $max_price > 0){
            $wh_price .= " AND 
                (IF((SELECT count(id) FROM mastermenu WHERE userid=u.id AND itemprice <= '".$max_price."')>0, 1, 0)=1 OR 
                IF((SELECT count(id) FROM packages WHERE userid=u.id AND weeklyprice <= '".$max_price."')>0, 1, 0)=1)";
        } 
        if($rating != ""){
            $where .= " AND temp.averagerating >= '".$rating."'";
        }
        
        $res = $db->pdoQuery("
                    
            SELECT temp.id,temp.kitchenid,temp.kitchenname,
                temp.address,temp.provincename,temp.cityname,temp.pincode,
                temp.averagerating,temp.countreview,temp.discount,temp.createddate,temp.foodtype,temp.profile_image,temp.is_favourite,temp.mealtype
    
            FROM (
    
                SELECT u.id,u.kitchenid,u.kitchenname,u.address,
                CAST(IFNULL((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)),0) AS DECIMAL(2,1)) as averagerating, 
                (SELECT count(fd.id) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)) as countreview,
    
                IFNULL((SELECT discount FROM offer WHERE discounttype=0 AND (userid=0 OR userid=u.id) AND enddate >= CURDATE() ORDER BY discount DESC LIMIT 1),'0') as discount,u.createddate,
    
                p.name as provincename,c.name as cityname,u.pincode,u.foodtype,u.profile_image,
    
                IF(IFNULL((SELECT count(id) FROM favorite_kitchen WHERE customerid='".$customer_id."' AND kitchenid=u.id),'0')>0,1,0) as is_favourite,
    
                u.mealtype
                
                FROM user as u
                LEFT JOIN province as p ON p.id=u.stateid
                LEFT JOIN city as c ON c.id=u.cityid
                WHERE u.status=1 AND u.userstatus=1 AND u.usertype=0 
                ".$wh_price."
                ".$wh_plan."
    
            ) as temp
            ".$where."
            ORDER BY temp.createddate DESC
    
        ")->results();
    
        /* $res = $db->pdoQuery("
                
            SELECT temp.id,temp.userid,temp.kitchenid,temp.kitchenname,temp.itemname,temp.image,temp.cuisinetype,temp.menutype,temp.mealtype,temp.category,temp.mealplan,
                temp.price,
                temp.address,temp.provincename,temp.cityname,temp.pincode,
                temp.averagerating,temp.countreview,temp.discount,temp.createddate
    
            FROM (
    
                SELECT m.id,m.userid,u.kitchenid,u.kitchenname,u.address,m.itemname,m.image,m.cuisinetype,m.menutype,m.itemtype as mealtype,m.category,
                CAST(IFNULL((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)),0) AS DECIMAL(2,1)) as averagerating, 
                (SELECT count(fd.id) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)) as countreview,
    
                IFNULL((SELECT discount FROM offer WHERE discounttype=0 AND userid=u.id AND enddate >= CURDATE() ORDER BY discount DESC LIMIT 1),'0') as discount,m.createddate,
    
                p.name as provincename,c.name as cityname,u.pincode,
                '2' as mealplan,
                m.itemprice as price
    
                FROM mastermenu as m
                INNER JOIN user as u ON u.id=m.userid AND u.status=1 AND u.userstatus=1
                LEFT JOIN province as p ON p.id=u.stateid
                LEFT JOIN city as c ON c.id=u.cityid
                WHERE u.status=1 AND u.usertype=0 ".$wh_item."
    
                UNION 
    
                SELECT pkg.id,pkg.userid,u.kitchenid,u.kitchenname,u.address,pkg.packagename as itemname,'' as image,pkg.cuisinetype,pkg.mealfor as menutype,pkg.mealtype,IF(pkg.mealtype=0,'Veg','Non Veg') as category,
                CAST(IFNULL((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)),0) AS DECIMAL(2,1)) as averagerating, 
                (SELECT count(fd.id) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)) as countreview,
    
                IFNULL((SELECT discount FROM offer WHERE discounttype=0 AND userid=u.id AND enddate >= CURDATE() ORDER BY discount DESC LIMIT 1),'0') as discount,pkg.createddate,
    
                p.name as provincename,c.name as cityname,u.pincode,
                ".$sel_pkg."
    
                FROM packages as pkg
                INNER JOIN user as u ON u.id=pkg.userid AND u.status=1 AND u.userstatus=1
                LEFT JOIN province as p ON p.id=u.stateid
                LEFT JOIN city as c ON c.id=u.cityid
                WHERE u.status=1 AND u.usertype=0 ".$wh_pkg."
    
            ) as temp
            ".$where."
            ORDER BY temp.createddate DESC
    
        ")->results(); */
        
        if(count($res) > 0)
        {
            foreach ($res as $key => $value) {
                
                if($customer_address!="" && $value['address']!=""){
                    $kitchen_address = $value['address'].", ".$value['cityname'].", ".$value['provincename'];
                    $distance = json_decode(get_duration_between_two_places($GOOGLE_MAP_API_KEY, $customer_address, $kitchen_address, 'both', 1));
                    
                    $total_distance = str_replace(",", "", $distance->distance);
                    $arriving_time = $distance->duration;
                }else{
                    $total_distance = 0;
                    $arriving_time = "Address not found";
                }

                if (file_exists(DIR_UPD . 'profile/' . $value['profile_image']) && $value['profile_image'] != '') {
                    $image = SITE_UPD . 'profile/' . $value['profile_image'];
                } else {
                    $image = SITE_URL . 'assets/image/userprofile/noimage.png';
                }

                if ($total_distance <= $RADIUS_IN_KM || $RADIUS_IN_KM == 0) {
                    $return_array[] = array(
                        "kitchen_id"    => $value['id'],   
                        "kitchenname"    => $value['kitchenname'],   
                        // "itemname"       => $value['itemname'],
                        "address"        => $value['address'],
                        "mealtype"        => $value['mealtype'],
                        "cuisinetype"    => $value['foodtype'],
                        "discount"       => $value['discount'],   
                        "image"          => $image,
                        "average_rating" => $value['averagerating'],
                        "total_review"   => $value['countreview'],
                        "time"           => $arriving_time,
                        "is_favourite"   => $value['is_favourite']
                    );
                }
            }
            if(count($return_array) > 0){
                APIsuccess("success", $return_array);
            }else{
                APIError("Kitchen not found.");
            }
        }
        else
        {
            APIError("Kitchen not found.");
        }
    }
}
else {
	APIError("Token missing.");
}
