<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if (isset($user_id) && $user_id > 0) {
        if($name != '' && $email != '' && $mobile_number != ''){

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $checkEmail =  $db->pdoQuery("SELECT * FROM user WHERE id != '".$user_id."' AND email = '".$email."'")->results();
                
                if(count($checkEmail) <= 0)
                {
                    $checkMobilenumber =  $db->pdoQuery("SELECT * FROM user WHERE id != '" . $user_id . "' AND usertype=1 AND mobilenumber = '" . $mobile_number . "'")->results();

                    if(count($checkMobilenumber) <= 0){
                        
                        $update_array = array(
                            "kitchenname"    => $name,
                            "email"          => $email,
                            "mobilenumber"   => $mobile_number,
                            "modifieddate"   => date("Y-m-d H:i:s")
                        );
                        
                        $db->update("user", $update_array, array("id" => $user_id));
                        
                        $res =  $db->pdoQuery("SELECT * FROM user WHERE id = '" . $user_id . "'")->result();
                        
                        APIsuccess("Profile has been successfully updated.", $res);

                    }else{
                        APIError("Mobile number already registared.");
                    }
                    

                }else{
                    APIError("Email id already registared.");
                }

            }else{
                APIError("Enter valid email address.");
            }
                
        }else{
            APIError("Fill all required fields.");
        }
    } else {
        APIError("Login is mandatory.");
    }
}else{
	APIError("Token missing.");
}
