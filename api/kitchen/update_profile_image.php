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

            $res = $db->pdoQuery("SELECT * FROM user WHERE id=".$user_id)->result();
            $old_profile_image = $res['profile_image']; 
            $profile_image = $res['profile_image']; 

            $target_dir = DIR_UPD."profile/";
            if(!is_dir($target_dir)){
                @mkdir($target_dir);
            }
            if(isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != ""){
                $name = time();
                $profile_image = $name."_".$_FILES['profile_image']["name"];
                $target_file = $target_dir .$profile_image;
                move_uploaded_file($_FILES['profile_image']["tmp_name"], $target_file);
            }
            if($old_profile_image != "" && isset($_FILES['profile_image']['name'])) {
                @unlink($target_dir.$old_profile_image);
            }
            $update_array = array(
                "profile_image" => $profile_image
            );
            
            $db->update("user",$update_array,array("id"=>$user_id));

            APIsuccess("Profile image updated successfully.");
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
