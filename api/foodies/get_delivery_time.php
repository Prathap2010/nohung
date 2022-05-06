<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($package_id > 0){

		$res = $db->pdoQuery("SELECT p.id,p.packagename,p.mealfor FROM packages as p WHERE p.id='".$package_id."'")->result();
		
		if($res)
		{
			$breakfast_time = array("06:00-06:30","06:30-07:00","07:00-07:30","07:30-08:00","08:00-08:30","08:30-09:00");
			$lunch_time = array("11:00-11:30","11:30-12:00","12:30-13:00","13:30-14:00","14:00-14:30","14:30-15:00");
            $dinner_time = array("19:00-19:30","19:30-20:00","20:00-20:30","20:30-21:00","21:00-21:30","21:30-22:00");
			
			if($res['mealfor'] == 0){
				$return_array = $breakfast_time;
			}else if($res['mealfor'] == 1){
				$return_array = $lunch_time;
			}else{
				$return_array = $dinner_time;
			}

            APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Package not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



