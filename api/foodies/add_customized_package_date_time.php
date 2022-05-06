<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) && $user_id > 0){
        if($package_id > 0 && $delivery_startdate != "" && $delivery_enddate != "" && $delivery_time != ""){

            $res = $db->pdoQuery("SELECT id
                                FROM order_customized_package_date_time as o
                                WHERE o.userid=".$user_id." AND o.packageid=".$package_id)->result();
            
            $time = explode("-", $delivery_time);
            $delivery_fromtime = isset($time[0]) ? $time[0] : "";
            $delivery_totime = isset($time[1]) ? $time[1] : "";

            if(!empty($res))
            {
                $update_array = array(
                    "delivery_startdate"=>date("Y-m-d",strtotime(str_replace('/', '-',$delivery_startdate))),
                    "delivery_enddate"=>date("Y-m-d",strtotime(str_replace('/', '-',$delivery_enddate))),
                    "delivery_fromtime"=>date("H:i:s",strtotime($delivery_fromtime)),
                    "delivery_totime"=>date("H:i:s",strtotime($delivery_totime)),
                );
                
                $db->update('order_customized_package_date_time',$update_array,array('id'=>$res['id']));
            }
            else
            {
                $insert_array = array("userid"=>$user_id,
                            "packageid"=>$package_id,
                            "delivery_startdate"=>date("Y-m-d",strtotime(str_replace('/', '-',$delivery_startdate))),
                            "delivery_enddate"=>date("Y-m-d",strtotime(str_replace('/', '-',$delivery_enddate))),
                            "delivery_fromtime"=>date("H:i:s",strtotime($delivery_fromtime)),
                            "delivery_totime"=>date("H:i:s",strtotime($delivery_totime)),
                        );
        
                $db->insert("order_customized_package_date_time", $insert_array);
            }	
            APIsuccess("Package date & time added.",$return_array);
        }else{
            APIError("Fill all required fields.");
        }
    }else{
        APIError("Login is require for add package to cart !");
    }
}
else
{
	APIError("Token missing.");
}



