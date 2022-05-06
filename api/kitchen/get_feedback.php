<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
	{

        $checkUserId = $db->count("user",array("id"=>$user_id,"usertype"=>0));

        if($checkUserId > 0)
        {
            $res = $db->pdoQuery("SELECT f.id,foodie.kitchenname as customer_name,foodie.profile_image as image,f.rating,f.message,f.createddate, 
            
            CAST((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=f.kitchen_id) AS DECIMAL(2,1)) as totalrating, 
            (SELECT count(fd.id) FROM feedback as fd WHERE fd.kitchen_id=f.kitchen_id) as totalreview
                                    FROM feedback as f 
                                    LEFT JOIN user as foodie ON foodie.id=f.customer_id
                                    WHERE kitchen_id = '".$user_id."'
                                    ORDER BY f.createddate DESC
                                ")
                        ->results();
        
            $excellent = $db->count("feedback",array("rating"=>"5","kitchen_id"=>$user_id));
            $good = $db->count("feedback",array("rating"=>"4","kitchen_id"=>$user_id));
            $average = $db->count("feedback",array("rating"=>"3","kitchen_id"=>$user_id));
            $poor = $db->count("feedback",array("rating"=>"2","kitchen_id"=>$user_id));

            if(count($res) > 0)
            {
                $return_array['totalrating'] = $res[0]['totalrating'];
                $return_array['totalreview'] = $res[0]['totalreview'];
                $return_array['excellent'] = $excellent;
                $return_array['good'] = $good;
                $return_array['average'] = $average;
                $return_array['poor'] = $poor;

                foreach ($res as $key => $value) {
                    
                    if($value['image'] != "" && file_exists(DIR_UPD.'profile/'.$value['image'])){ 
                        $customer_image = SITE_UPD.'profile/'.$value['image'];
                    }else{
                        $customer_image = SITE_URL.'assets/image/userprofile/noimage.png';
                    }

                    $return_array['feedback'][] = array(
                        "customer_name" => $value['customer_name'],
                        "customer_photo"=> $customer_image,
                        "rating"        => $value['rating'],
                        "message"       => $value['message'],
                        "createdtime"   => $value['createddate']
                    );
                }
                APIsuccess("success",$return_array);
            }
            else
            {
                APIError("Account details not found.");
            }
        }
        else
        {
            APIError("Invalid user id.");
        }

    }
    else
    {
        APIError("User invalid.");
    }	
}
else 
{
	APIError("Token missing.");
}
