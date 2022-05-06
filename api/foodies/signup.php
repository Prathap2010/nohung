<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{   
    if($name != '' && $email != '' && $mobilenumber != '' && $password != ''){

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $checkEmail =  $db->count("user",array("email"=>$email));

            if($checkEmail <= 0)
            {
                $checkMobilenumber =  $db->count("user",array("usertype"=>"1", "mobilenumber"=>$mobilenumber));

                if($checkMobilenumber <= 0){
                    
                    $customerid = time();
                    
                    $insert_array = array(
                        "usertype"       => 1,
                        "kitchenname"    => $name,
                        "email"          => $email,
                        "mobilenumber"   => $mobilenumber,
                        "kitchenid"      => $customerid,
                        "password"       => $password,
                        "userstatus"     => 1,
                        "status"         => 1,
                        "createddate"    => date("Y-m-d H:i:s"),
                        "modifieddate"   => date("Y-m-d H:i:s")
                    );
                    //print_r($insert_array);exit;
                    $user_id = $db->insert("user",$insert_array)->getLastInsertId();

                    /* $insert_array['user_id'] = $user_id;

                    $subject = 'Register';
                    $content = '<p>Dear '.$name.',<br />
                    <br />
                    Thank you for the&nbsp;register in NOHUNG Foodies system.</p>
                    
                    <p>The Foodies ID of your account is&nbsp;:&nbsp;<strong>'.$customerid.'</strong>&nbsp;</p>
                    
                    <p>The password of your account is&nbsp;: <strong>'.$password.'</strong><br />
                    <br />
                    &nbsp;</p>
                    
                    <p><strong>Thanks,</strong>
                    <strong>Nohung</strong>';

                    send_email($email,$subject,$content); */

                    $return_array = array(
                        "id"            => $user_id,
                        "name"          => $name,
                        "email"         => $email,
                        "mobilenumber"  => $mobilenumber
                    );
                    
                    APIsuccess("Register has been successfully completed.", $return_array);

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
}else{
	APIError("Token missing.");
}
