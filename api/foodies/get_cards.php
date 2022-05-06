<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0){

		$res = $db->pdoQuery("SELECT *
							  FROM cards
							  WHERE userid = ".$userid." 
							  ORDER BY id DESC")->results();
		//echo '<pre>';print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				if($value['image'] != "" && file_exists(DIR_UPD.'cards/'.$value['image'])){ 
                    $image = SITE_UPD.'cards/'.$value['image'];
                }else{
                    $image = SITE_URL.'assets/image/noimage.jpg';
                }

				$return_array[] = array(
					"id" => $value['id'],
					"card_name" => $value['card_name'],
					"image" => $image,
					"card_number" => decrypt($value['card_number']),
					"cvv" => $value['cvv']!=""?decrypt($value['cvv']):"",
					"holder_name" => $value['holder_name'],
					"valid_thru" => decrypt($value['valid_thru']),
					"is_default" => $value['is_default']
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Cards not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



