<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
	$checkEmail =  $db->count("user",array("email"=>$email));

    if($checkEmail <= 0)
    {

        $kitchen_id = time();
    	$password = generateRandomString(8);
    	
        $res_setting = $db->pdoQuery("SELECT sitename,email,logo,mapapikey FROM sitesetting WHERE id=1")->result();
        $GOOGLE_MAP_API_KEY = $res_setting['mapapikey'];
        
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$GOOGLE_MAP_API_KEY;
        $geocode = @file_get_contents($url);
        $output= json_decode($geocode);
        
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;

        $insert_array = array(
    		"kitchenname"  =>$kitchenname,
            "email"        =>$email,
            "address"      =>$address,
            "latitude"     =>$latitude,
            "longitude"    =>$longitude,
            "stateid"      =>$stateid,
            "cityid"       =>$cityid,
            "pincode"          => $pincode,
            "contactname"      => $contactpersonname,
            "role"             => $contactpersonrole,
            "mobilenumber"     => $mobilenumber,
            "kitchencontactnumber" => $kitchenscontactnumber,
            "fssailicenceno"       => $FSSAILicenceNo,
            "expirydate"           => $expirydate,
            "panno"                => $pancard,
            "gstno"                => $gstnumber,
            "userstatus"           => 0,
            "status"               => 0,
            "createddate"          => date("Y-m-d H:i:s"),
            "modifieddate"         => date("Y-m-d H:i:s"),
            "kitchenid"            => $kitchen_id,
            "password"             => $password,
        );

        $menu_file_name = $document_file_name = "";

        if(isset($_FILES["menufile"]["name"]) && $_FILES["menufile"]["name"] != "")
        {    
            $name = time();
            $target_dir = DIR_UPD."menu/";
            $menu_file_name = $name."_".$_FILES["menufile"]["name"];
            $target_file = $target_dir .$menu_file_name;
            move_uploaded_file($_FILES["menufile"]["tmp_name"], $target_file);
            $insert_array['menufile'] = $menu_file_name;            
            
            $menu_file_name = SITE_UPD."menu/".$menu_file_name;
        }
        
        $user_id = $db->insert("user",$insert_array)->getLastInsertId();

        if(isset($_FILES["documents"]["name"]) && $_FILES["documents"]["name"] != "")
        {    
            $target_dir = DIR_UPD."documents/";
            
            $name = time();
            $target_file = $target_dir .$name."_".$_FILES["documents"]["name"];
            move_uploaded_file($_FILES["documents"]["tmp_name"], $target_file);
            $image_name = $name."_".$_FILES["documents"]["name"];            
            
            $insert_array1 = array(
                "userid"  => $user_id,
                "type"    => "0",
                "file"    => $image_name,
            );
            $db->insert("userdocuments",$insert_array1);

            $document_file_name = SITE_UPD."documents/".$image_name;
        }

        $insert_array['menu_file'] = $menu_file_name;
        $insert_array['document_file'] = $document_file_name;
        
        $insert_array['user_id'] = $user_id;


        /*****SEND MAIL TO USER */
        
        //Get email template on database
        $res_emailtemplate = $db->pdoQuery("SELECT * FROM emailtemplate WHERE emailtype=1")->result();
        
        $subject = $res_emailtemplate['subject'];
        
        /* REPLACE MAIL BODY KEY AND VALUES */
        $strEmail1 = str_replace('\"', '"', $res_emailtemplate['message']);
        $strEmail1 = str_replace('&nbsp;', ' ', $strEmail1);

        $strEmail1 = str_replace("{kitchenname}", $kitchenname, $strEmail1);
        $strEmail1 = str_replace("{kitchenID}", $kitchen_id, $strEmail1);
        $strEmail1 = str_replace("{password}", $password, $strEmail1);
        $strEmail1 = str_replace("{logo}", '<a href="'.SITE_URL.'"><img src="'.SITE_UPD.'setting/'.$res_setting['logo'].'" style="width:auto;height:60px;"></a>', $strEmail1);
        $strEmail1 = str_replace("{sitename}", $res_setting['sitename'], $strEmail1);
        $content = str_replace("{siteemail}", $res_setting['email'], $strEmail1);

        send_email($email,$subject,$content);

    	APIsuccess("Register has been successfully completed.",$insert_array);
    }
    else
    {
        APIError("Email id already registered.");
    }    
}
else 
{
	APIError("Token missing.");
}
