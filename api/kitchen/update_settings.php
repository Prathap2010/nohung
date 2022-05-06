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

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if(strlen($mobile_number) ==10 && is_numeric($mobile_number)){

                    $checkEmail = $db->pdoQuery("SELECT id FROM user WHERE id != '".$user_id."' AND email='".$email."'")->results();
                    
                    if(count($checkEmail) == 0)
                    {
                        $res = $db->pdoQuery("SELECT mapapikey FROM sitesetting WHERE id=1")->result();
                        $GOOGLE_MAP_API_KEY = $res['mapapikey'];
                        
                        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$GOOGLE_MAP_API_KEY;
                        $geocode = @file_get_contents($url);
                        $output= json_decode($geocode);
                        
                        $latitude = $output->results[0]->geometry->location->lat;
                        $longitude = $output->results[0]->geometry->location->lng;
                        
                        $update_array = array(
                            "kitchenname"   => $kitchen_name,
                            "address"       => $address,
                            "latitude"      => $latitude,
                            "longitude"     => $longitude,
                            "email"         => $email,
                            "mobilenumber"  => $mobile_number,
                            "password"      => $password
                        );
                        
                        $db->update("user",$update_array,array("id"=>$user_id));
        
                        APIsuccess("Setting updated successfully.");
                    }
                    else
                    {
                        APIError("Email id already registared.");
                    }
                }
                else
                {
                    APIError("Please enter 10 digits and numeric value of mobile number.");
                }
            }
            else
            {
                APIError("Invalid email format.");
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
