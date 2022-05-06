<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();
$results = 0;

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
	{

        /* GET RECORDS OF SOUTH INDIAN BREAKFAST - VEG */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=0 AND menutype=0 AND itemtype=0 ORDER BY id ASC")->results();
	
        if(count($res) > 0)
		{
            foreach ($res as $key => $value) {

                $return_array['southindian']['breakfast']['veg'][] = array(
					"image"     => $value['image'],
					"price"     => $value['itemprice'],
					"name"      => $value['itemname']
				);

            }
            
            $results++;
        }

        /* GET RECORDS OF SOUTH INDIAN BREAKFAST - NON-VEG */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=0 AND menutype=0 AND itemtype=1 ORDER BY id ASC")->results();
        
        if(count($res) > 0)
		{
			foreach ($res as $key => $value) {

                $return_array['southindian']['breakfast']['nonveg'][] = array(
					"image"     => $value['image'],
					"price"     => $value['itemprice'],
					"name"      => $value['itemname']
				);

            }
            
            $results++;
        }

        /* GET RECORDS OF SOUTH INDIAN LUNCH */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=0 AND menutype=1 ORDER BY id ASC")->results();
	
        if(count($res) > 0)
		{
            foreach ($res as $key => $value) {

                $return_array['southindian']['lunch'][$value['category']][] = array(
					"image"     => $value['image'],
					"price"     => $value['itemprice'],
					"name"      => $value['itemname']
				);

            }
            
            $results++;
        }

        /* GET RECORDS OF SOUTH INDIAN DINNER */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=0 AND menutype=2 ORDER BY id ASC")->results();
	
        if(count($res) > 0)
		{
            foreach ($res as $key => $value) {

                $return_array['southindian']['dinner'][$value['category']][] = array(
					"image"     => $value['image'],
					"price"     => $value['itemprice'],
					"name"      => $value['itemname']
				);

            }
            
            $results++;
        }

        /* GET RECORDS OF NORTH INDIAN BREAKFAST - VEG */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=1 AND menutype=0 AND itemtype=0 ORDER BY id ASC")->results();
	
        if(count($res) > 0)
		{
            foreach ($res as $key => $value) {

                $return_array['northindian']['breakfast']['veg'][] = array(
					"image"     => $value['image'],
					"price"     => $value['itemprice'],
					"name"      => $value['itemname']
				);

            }
            
            $results++;
        }

        /* GET RECORDS OF NORTH INDIAN BREAKFAST - NON-VEG */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=1 AND menutype=0 AND itemtype=1 ORDER BY id ASC")->results();
        
        if(count($res) > 0)
		{
			foreach ($res as $key => $value) {

                $return_array['northindian']['breakfast']['nonveg'][] = array(
					"image"     => $value['image'],
					"price"     => $value['itemprice'],
					"name"      => $value['itemname']
				);

            }
            
            $results++;
        }

        /* GET RECORDS OF NORTH INDIAN LUNCH */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=1 AND menutype=1 ORDER BY id ASC")->results();
	
        if(count($res) > 0)
		{
            foreach ($res as $key => $value) {

                $return_array['northindian']['lunch'][$value['category']][] = array(
					"image"     => $value['image'],
					"price"     => $value['itemprice'],
					"name"      => $value['itemname']
				);

            }
            
            $results++;
        }

        /* GET RECORDS OF NORTH INDIAN DINNER */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=1 AND menutype=2 ORDER BY id ASC")->results();
	
        if(count($res) > 0)
		{
            foreach ($res as $key => $value) {

                $return_array['northindian']['dinner'][$value['category']][] = array(
					"image"     => $value['image'],
					"price"     => $value['itemprice'],
					"name"      => $value['itemname']
				);

            }
            
            $results++;
        }

        /* GET RECORDS OF OTHER INDIAN BREAKFAST - VEG */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=2 AND menutype=0 AND itemtype=0 ORDER BY id ASC")->results();

        if(count($res) > 0)
        {
            foreach ($res as $key => $value) {

                $return_array['otherindian']['breakfast']['veg'][] = array(
                    "image"     => $value['image'],
                    "price"     => $value['itemprice'],
                    "name"      => $value['itemname']
                );

            }
            
            $results++;
        }

        /* GET RECORDS OF OTHER INDIAN BREAKFAST - NON-VEG */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=2 AND menutype=0 AND itemtype=1 ORDER BY id ASC")->results();
        
        if(count($res) > 0)
        {
            foreach ($res as $key => $value) {

                $return_array['otherindian']['breakfast']['nonveg'][] = array(
                    "image"     => $value['image'],
                    "price"     => $value['itemprice'],
                    "name"      => $value['itemname']
                );

            }
            
            $results++;
        }

        /* GET RECORDS OF OTHER INDIAN LUNCH */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=2 AND menutype=1 ORDER BY id ASC")->results();
    
        if(count($res) > 0)
        {
            foreach ($res as $key => $value) {

                $return_array['otherindian']['lunch'][$value['category']][] = array(
                    "image"     => $value['image'],
                    "price"     => $value['itemprice'],
                    "name"      => $value['itemname']
                );

            }
            
            $results++;
        }

        /* GET RECORDS OF OTHER INDIAN DINNER */
        $res = $db->pdoQuery("SELECT * FROM mastermenu WHERE userid = '".$user_id."' AND cuisinetype=2 AND menutype=2 ORDER BY id ASC")->results();
    
        if(count($res) > 0)
        {
            foreach ($res as $key => $value) {

                $return_array['otherindian']['dinner'][$value['category']][] = array(
                    "image"     => $value['image'],
                    "price"     => $value['itemprice'],
                    "name"      => $value['itemname']
                );

            }
            
            $results++;
        }


        if($results > 0){
            APIsuccess("success",$return_array);
        }else{
            APIError("Menu not found.");    
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
