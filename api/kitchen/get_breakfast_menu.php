<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if(isset($kitchen_id) && $kitchen_id > 0)
	{
        // $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=0 AND menutype=0")->results();

        $return_array['south_indian'] = $south_indian_veg_items = $south_indian_nonveg_items = array();
        /* if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                $category = ($value['itemtype'] == 0 ? "Veg" : "Non Veg");
				
				$list = array();
				
				$array = array(
					"menu_id"      => $value['id'],
					"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
					"itemname"     => $value['itemname'],
					"itemprice"    => $value['itemprice'],
					"instock"      => $value['instock'],
					"image"        => get_menu_image($value['image'])
				);
				
				if(in_array($category, $category_arr)){
					$key = array_search($category, array_column($south_indian_items, 'category'));
					$south_indian_items[$key]['list'][] = $array;
				}else{
					$category_arr[] = $category;

					$list[] = $array;

					$south_indian_items[] = array("category"=>$category,"list"=>$list); 
				}
			}
		} */

		//SOUTH VEG
		$res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=0 AND menutype=0 AND itemtype=0")->results();
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$south_indian_veg_items[] = array(
					"menu_id"      => $value['id'],
					"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
					"itemname"     => $value['itemname'],
					"itemprice"    => $value['itemprice'],
					"instock"      => $value['instock'],
					"image"        => get_menu_image($value['image'])
				);
			}
		}
		$return_array['south_indian'][] = array("category"=>"Veg","list"=>$south_indian_veg_items); 
		
		//SOUTH NON VEG
		$res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=0 AND menutype=0 AND itemtype=1")->results();
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$south_indian_nonveg_items[] = array(
					"menu_id"      => $value['id'],
					"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
					"itemname"     => $value['itemname'],
					"itemprice"    => $value['itemprice'],
					"instock"      => $value['instock'],
					"image"        => get_menu_image($value['image'])
				);
			}
		}
		$return_array['south_indian'][] = array("category"=>"Non Veg","list"=>$south_indian_nonveg_items); 
		
		//NORTH VEG
        $return_array['north_indian'] = $north_indian_veg_items = $north_indian_nonveg_items = array();
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=1 AND menutype=0 AND itemtype=0")->results();
		
        if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                $north_indian_veg_items[] = array(
					"menu_id"      => $value['id'],
					"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
					"itemname"     => $value['itemname'],
					"itemprice"    => $value['itemprice'],
					"instock"      => $value['instock'],
					"image"        => get_menu_image($value['image'])
				);
			}
			
		}
		$return_array['north_indian'][] = array("category"=>"Veg","list"=>$north_indian_veg_items); 

		$res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=1 AND menutype=0 AND itemtype=1")->results();
		
        if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                $north_indian_nonveg_items[] = array(
					"menu_id"      => $value['id'],
					"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
					"itemname"     => $value['itemname'],
					"itemprice"    => $value['itemprice'],
					"instock"      => $value['instock'],
					"image"        => get_menu_image($value['image'])
				);
			}
			
		}
		$return_array['north_indian'][] = array("category"=>"Non Veg","list"=>$north_indian_nonveg_items); 

        $return_array['other_indian'] = $other_indian_veg_items = $other_indian_nonveg_items = array();
		
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=2 AND menutype=0 AND itemtype=0")->results();

		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                $other_indian_veg_items[] = array(
					"menu_id"      => $value['id'],
					"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
					"itemname"     => $value['itemname'],
					"itemprice"    => $value['itemprice'],
					"instock"      => $value['instock'],
					"image"        => get_menu_image($value['image'])
				);
			}
			
		}
		$return_array['other_indian'][] = array("category"=>"Veg","list"=>$other_indian_veg_items); 

		$res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$kitchen_id."' AND cuisinetype=2 AND menutype=0 AND itemtype=1")->results();

		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                $other_indian_nonveg_items[] = array(
					"menu_id"      => $value['id'],
					"cuisinetype"  => get_cuisinetype($value['cuisinetype']),
					"itemname"     => $value['itemname'],
					"itemprice"    => $value['itemprice'],
					"instock"      => $value['instock'],
					"image"        => get_menu_image($value['image'])
				);
			}
			
		}
		$return_array['other_indian'][] = array("category"=>"Non Veg","list"=>$other_indian_nonveg_items); 

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



