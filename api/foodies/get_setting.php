<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    $res = $db->pdoQuery("SELECT taxonorder,delivery_charge_per_km
                            FROM sitesetting
                            WHERE id=1
                        ")->result();
    
    if(!empty($res))
    {
        
        $return_array = array(
            "tax_on_order"          => number_format($res['taxonorder'],2,'.',''),
            "delivery_charge_per_km"=> number_format($res['delivery_charge_per_km'],2,'.','')
        );

        APIsuccess("success",$return_array);
        
    }
    else
    {
        APIError("Record not found.");
    }	
	
}
else
{
	APIError("Token missing.");
}



