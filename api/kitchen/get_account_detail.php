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
            $res = $db->pdoQuery("SELECT u.id,u.kitchenname,u.email,u.password,u.address,u.mobilenumber,u.firmtype,u.foodtype,u.fromtime,u.totime,u.opendays,u.mealtype,u.menufile, 
                u.profile_image,u.description,
                CAST(IFNULL((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id),0) AS DECIMAL(2,1)) as totalrating
                FROM user as u WHERE u.id = '".$user_id."'")->result();
        
            if($res)
            {
                $res1 = $db->pdoQuery("SELECT id as document_id,file as documentfile FROM userdocuments WHERE userid = '".$res['id']."'")->result();
                $documentfile = !empty($res1)?$res1['documentfile']:"";
                
                if($res['profile_image'] != "" && file_exists(DIR_UPD.'profile/'.$res['profile_image'])){ 
                    $profile_image = SITE_UPD.'profile/'.$res['profile_image'];
                }else{
                    $profile_image = SITE_URL.'assets/image/userprofile/noimage.png';
                }
                if($res['menufile'] != "" && file_exists(DIR_UPD.'menu/'.$res['menufile'])){ 
                    $menufile = SITE_UPD.'menu/'.$res['menufile'];
                }else{
                    $menufile = SITE_URL.'assets/image/noimage.jpg';
                }
                if($documentfile != "" && file_exists(DIR_UPD.'documents/'.$documentfile)){ 
                    $documentfile = SITE_UPD.'documents/'.$documentfile;
                }else{
                    $documentfile = SITE_URL.'assets/image/noimage.jpg';
                }

                $return_array = array(
                    "user_id"       => $res['id'],
                    "kitchen_name"  => $res['kitchenname'],
                    "description"   => $res['description'],
                    "address"       => $res['address'],
                    "email"         => $res['email'],
                    "mobile_number" => $res['mobilenumber'],
                    "password"      => $res['password'],
                    "type_of_firm"  => $res['firmtype'],
                    "type_of_food"  => explode(",", $res['foodtype']),
                    "from_time"     => date("h:i A",strtotime($res['fromtime'])),
                    "to_time"       => date("h:i A",strtotime($res['totime'])),
                    "open_days"     => explode(",", $res['opendays']),
                    "type_of_meals" => explode(",",$res['mealtype']),
                    "totalrating"   => $res['totalrating'],
                    "menufile"      => $menufile,
                    "documentfile"  => $documentfile,
                    "profile_image" => $profile_image,
                );

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
