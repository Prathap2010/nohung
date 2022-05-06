<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if(isset($kitchen_id) && $kitchen_id > 0)
	{
		// $category_array = array("Veg","Non Veg","Rice","Dal","Bread","Others");
		$category_array = array("Veg","Non Veg");

		$return_array['south_indian'] = array();
		foreach($category_array as $category){
			$si_items = array();
			
			$res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=0 AND (menutype=1 OR menutype=2 OR menutype=3) AND category='".$category."'")->results();
			if(count($res) > 0)
			{
				foreach ($res as $key => $value) {
					
					$si_items[] = array(
						"menu_id"      => $value['id'],
						"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
						"itemname"     => $value['itemname'],
						"itemprice"    => $value['itemprice'],
						"instock"      => $value['instock'],
						"menutype"     => $value['menutype'],
						"image"        => get_menu_image($value['image'])
					);
				}
			}
			$return_array['south_indian'][] = array("category"=>$category,"list"=>$si_items); 
		}
		
		$return_array['north_indian'] = array();
		foreach($category_array as $category){
			$ni_items = array();
			
			$res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=1 AND (menutype=1 OR menutype=2 OR menutype=3) AND category='".$category."'")->results();
			if(count($res) > 0)
			{
				foreach ($res as $key => $value) {
					
					$ni_items[] = array(
						"menu_id"      => $value['id'],
						"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
						"itemname"     => $value['itemname'],
						"itemprice"    => $value['itemprice'],
						"instock"      => $value['instock'],
						"menutype"     => $value['menutype'],
						"image"        => get_menu_image($value['image'])
					);
				}
			}
			$return_array['north_indian'][] = array("category"=>$category,"list"=>$ni_items); 
		}

        $return_array['other_indian'] = array();
		foreach($category_array as $category){
			$oi_items = array();
			
			$res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=2 AND (menutype=1 OR menutype=2 OR menutype=3) AND category='".$category."'")->results();
			if(count($res) > 0)
			{
				foreach ($res as $key => $value) {
					
					$oi_items[] = array(
						"menu_id"      => $value['id'],
						"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
						"itemname"     => $value['itemname'],
						"itemprice"    => $value['itemprice'],
						"instock"      => $value['instock'],
						"menutype"     => $value['menutype'],
						"image"        => get_menu_image($value['image'])
					);
				}
			}
			$return_array['other_indian'][] = array("category"=>$category,"list"=>$oi_items); 
		}

        // print_r($return_array);
        APIsuccess("success",$return_array);
	}
	else
	{
		APIError("state id not found.");
	}	
}
else
{
	APIError("Token missing.");
}



