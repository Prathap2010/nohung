<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

        
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

                IF(IFNULL((SELECT count(id) FROM favorite_kitchen WHERE customerid='". $user_id."' AND kitchenid=u.id),'0')>0,1,0) as is_favourite,

                u.mealtype
                
                FROM user as u
                LEFT JOIN province as p ON p.id=u.stateid
                LEFT JOIN city as c ON c.id=u.cityid
                WHERE u.status=1 AND u.userstatus=1 AND u.usertype=0 AND
                    (u.kitchenname LIKE '%" . $search_query . "%' OR 
                    u.address LIKE '%" . $search_query . "%' OR
                    p.name LIKE '%" . $search_query . "%' OR 
                    c.name LIKE '%" . $search_query . "%' OR 
                    u.pincode LIKE '%" . $search_query ."%' OR
                    IF((SELECT count(id) FROM packages WHERE userid=u.id AND (packagename LIKE '%" . $search_query . "%'))>0, 1, 0)=1 OR
                    IF((SELECT count(id) FROM mastermenu WHERE userid=u.id AND (itemname LIKE '%" . $search_query . "%'))>0, 1, 0)=1
                    )
                GROUP BY u.id

            ) as temp
            ORDER BY temp.createddate DESC
    
        ")->results();
    
        if(count($res) > 0)
        {
            foreach ($res as $key => $value) {
                
                if (file_exists(DIR_UPD . 'profile/' . $value['profile_image']) && $value['profile_image'] != '') {
                    $image = SITE_UPD . 'profile/' . $value['profile_image'];
                } else {
                    $image = SITE_URL . 'assets/image/userprofile/noimage.png';
                }

                $return_array[] = array(
                    "kitchen_id"     => $value['id'],   
                    "kitchenname"    => $value['kitchenname'],   
                    "address"        => $value['address'],
                    "mealtype"       => $value['mealtype'],
                    "cuisinetype"    => $value['foodtype'],
                    "discount"       => $value['discount'],   
                    "image"          => $image,
                    "average_rating" => $value['averagerating'],
                    "total_review"   => $value['countreview'],
                    "is_favourite"   => $value['is_favourite']
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



