<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{   
    if($name != '' && $email != '' && $cityid != '' && $mobilenumber != '' && $biketype != '' && $youhavelicense != ''){

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $checkEmail =  $db->count("user",array("email"=>$email));

            if($checkEmail <= 0)
            {
                $riderId = time();
                $password = generateRandomString(8);

                $insert_array = array(
                    "usertype"       => 2,
                    "kitchenname"    => $name,
                    "email"          => $email,
                    "riderid"        => $riderId,
                    "cityid"         => $cityid,
                    "mobilenumber"   => $mobilenumber,
                    "biketype"       => $biketype,
                    "youhavelicense" => $youhavelicense,
                    "userstatus"     => 0,
                    "status"         => 0,
                    "createddate"    => date("Y-m-d H:i:s"),
                    "modifieddate"   => date("Y-m-d H:i:s"),
                    "password"       => $password
                );
                //print_r($insert_array);exit;
                $user_id = $db->insert("user",$insert_array)->getLastInsertId();
        
                $insert_array['user_id'] = $user_id;

                $subject = 'Register';
                $content = '<p>Dear '.$name.',<br />
                <br />
                Thank you for the&nbsp;register in NOHUNG Rider system.</p>
                
                <p>The Rider ID of your account is&nbsp;:&nbsp;<strong>'.$riderId.'</strong>&nbsp;</p>
                
                <p>The password of your account is&nbsp;: <strong>'.$password.'</strong><br />
                <br />
                &nbsp;</p>
                
                <p><strong>Thanks,</strong>
                <strong>Nohung</strong>';

                send_email($email,$subject,$content);
        
                APIsuccess("Register has been successfully completed.",$insert_array);

            }else{
                APIError("Email id already registared.");
            }

        }else{
            APIError("Enter valid email address.");
        }
            
    }else{
        APIError("Fill all required fields.");
    }
}else{
	APIError("Token missing.");
}
