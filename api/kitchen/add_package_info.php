<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($kitchen_id) AND $kitchen_id > 0)
	{
        if(!empty($package_id) && isset($day))
	    {
            $checkPackageId = $db->count("packages",array("id"=>$package_id,"userid"=>$kitchen_id));
    
            if($checkPackageId > 0)
            {
                if($day >= 1 && $day <= 7){

                    $res_weeklypackage = $db->pdoQuery("SELECT * FROM `weeklypackage` WHERE packageid=".$package_id." AND days='".$day."'")->result();
                    
                    $target_dir = DIR_UPD."menu/";
                    if(!is_dir($target_dir)){
                        @mkdir($target_dir);
                    }
    
                    if($_FILES['image']['name'] != ''){
                        $name = time();
                        $image = $name."_".$_FILES["image"]["name"];
                        $target_file = $target_dir .$image;
                        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                        
                        if(!empty($res_weeklypackage) && $res_weeklypackage['image']!=""){
                            @unlink($target_dir.$res_weeklypackage['image']);
                        }
                    }else{
                        $image = "";
                    }
    
                    if(!empty($res_weeklypackage)){
                        $weekly_package_id = $res_weeklypackage['id'];
    
                        $update_array = array(
                            "image"=> $image
                        );
                        
                        $db->update("weeklypackage",$update_array,array("id"=>$weekly_package_id));
    
                        $weeklypackageid = $weekly_package_id;
    
                    }else{
    
                        $insert_array = array(
                            "packageid"      => $package_id,
                            "days"           => $day,
                            "image"=> $image
                        );
                        
                        $weeklypackageid = $db->insert("weeklypackage",$insert_array)->getLastInsertId();
                        
                    }
    
                    APIsuccess("Package menu successfully added.", $return_array);
                }
                else
                {
                    APIError("Invalid days number.");
                }
            }
            else
            {
                APIError("Invalid package id.");
            }
        }else{
            APIError("Fill all required fields.");
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
