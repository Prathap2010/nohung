<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0){

        if($customer_address==""){
            APIError("Select customer location.");    
        }else{
    		//Get search recent keywords
    		$recent_search = $db->pdoQuery("SELECT * FROM searchhistory WHERE userid = '".$userid."'")->results();
    		//echo '<pre>';print_r($recent_search);exit;
    		if(count($recent_search) > 0)
    		{
    			foreach ($recent_search as $key => $value) {
    
    				$recent_search_array[] = array(
    					"keyword" => $value['keyword']
    				);
    			}
    		}else{
    			$recent_search_array[] = 'No recent search available';
    		}
    
    		//Get trending
    		$trending = $db->pdoQuery("SELECT k.id,k.kitchenname 
    									FROM orders as o
    									LEFT JOIN user as k ON(o.customerid = k.id)
    									GROUP BY k.id
    									ORDER BY k.id DESC
    									limit 2")->results();
    		//echo '<pre>';print_r($trending);exit;
    		if(count($trending) > 0)
    		{
    			foreach ($trending as $key => $value) {
    
    				$trending_array[] = array(
    					"kitchenname" => $value['kitchenname']
    				);
    			}
    		}else{
    			$trending_array[] = 'No trending kitchen available';
    		}
    
    		//Get kitchen recommandation
    		$res = $db->pdoQuery("SELECT mapapikey,radius_in_km FROM sitesetting WHERE id=1")->result();
        	$GOOGLE_MAP_API_KEY = $res['mapapikey'];
    		$RADIUS_IN_KM = $res['radius_in_km'];
        
        	/* $kitchen_recommandation = $db->pdoQuery("SELECT k.id,k.kitchenname,k.foodtype,(select image from mastermenu where userid = k.id) as image,k.address as kitchen_address,ok.address as customer_address,(select sum(id) from feedback where kitchen_id = k.id) as total_review,(select avg(rating) from feedback where kitchen_id = k.id) as avg_review,k.address as kitchen_address,ok.address as customer_address
    				FROM user as k
    				LEFT JOIN orders as o ON(o.customerid = k.id)
    				LEFT JOIN user as ok ON(ok.id = o.userid)
    				WHERE o.customerid = ".$userid." and ok.foodtype = k.foodtype
    				GROUP BY k.id")->results(); */
    
    		$kitchen_recommandation = $db->pdoQuery("
                    
    			SELECT temp.id,temp.kitchenid,temp.kitchenname,
    				temp.address,temp.provincename,temp.cityname,temp.pincode,
    				temp.averagerating,temp.countreview,temp.discount,temp.createddate,temp.foodtype,temp.profile_image,temp.is_favourite,temp.mealtype
    
                FROM (
    
                    SELECT u.id,u.kitchenid,u.kitchenname,u.address,
    				CAST(IFNULL((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)),0) AS DECIMAL(2,1)) as averagerating, 
    				(SELECT count(fd.id) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)) as countreview,
    
    				IFNULL((SELECT discount FROM offer WHERE discounttype=0 AND (userid=0 OR userid=u.id) AND enddate >= CURDATE() ORDER BY discount DESC LIMIT 1),'0') as discount,u.createddate,
    
    				p.name as provincename,c.name as cityname,u.pincode,u.foodtype,u.profile_image,
    
    				IF(IFNULL((SELECT count(id) FROM favorite_kitchen WHERE customerid='".$userid."' AND kitchenid=u.id),'0')>0,1,0) as is_favourite,
    
    				u.mealtype
    				
    				FROM user as u
    				INNER JOIN orders as o ON (o.customerid = '".$userid."' AND o.userid=u.id)
    				LEFT JOIN province as p ON p.id=u.stateid
    				LEFT JOIN city as c ON c.id=u.cityid
    				WHERE u.status=1 AND u.userstatus=1 AND u.usertype=0 
    				GROUP BY u.id
    
                ) as temp
                WHERE (temp.kitchenname LIKE '%".$search_location_or_kitchen."%' OR 
    				temp.address LIKE '%".$search_location_or_kitchen."%' OR
    				temp.provincename LIKE '%".$search_location_or_kitchen."%' OR 
    				temp.cityname LIKE '%".$search_location_or_kitchen."%' OR 
    				temp.pincode LIKE '%".$search_location_or_kitchen."%'                    
    			)
                ORDER BY temp.createddate DESC
     
            ")->results();
        
    		$kitchen_recommandation_array = array();
    		if(count($kitchen_recommandation) > 0)
    		{
    			foreach ($kitchen_recommandation as $key => $value) {
    				
    				if($customer_address!="" && $value['address']!=""){
    					$kitchen_address = $value['address'].", ".$value['cityname'].", ".$value['provincename'];
    					$distance = json_decode(get_duration_between_two_places($GOOGLE_MAP_API_KEY,$customer_address,$kitchen_address, 'both', 1));
    
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
    					$kitchen_recommandation_array[] = array(
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
    			if(count($kitchen_recommandation_array) == 0){
                    $kitchen_recommandation_array[] = 'No kitchen recommandation available';
                }
    		}
    		else
    		{
    			$kitchen_recommandation_array[] = 'No kitchen recommandation available';
    		}
    		$return_array[] = array(
    			"recent_search"  => $recent_search_array,
    			"trending"  => $trending_array,
    			"kitchen_recommandation"  => $kitchen_recommandation_array
    		);
    	
    		APIsuccess("success",$return_array);	
        }
	}else{
		APIError("Fill all required fields.");
	}
	
}
else
{
	APIError("Token missing.");
}



