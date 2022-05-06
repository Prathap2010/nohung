<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0 && $package_id > 0 && $weekly_package_id > 0){

		$res = $db->pdoQuery("SELECT m.id,IF(m.menutype=0, IF(m.itemtype=0,'Veg','Non Veg'),m.category) as categoryname,m.category,m.userid,m.cuisinetype,m.menutype,GROUP_CONCAT(DISTINCT m.id) as menu_ids
							  FROM mastermenu as m
                              INNER JOIN packages as p ON p.id=".$package_id."
						      WHERE m.id IN (SELECT menuid FROM weeklypackagemenu WHERE weeklypackageid=".$weekly_package_id. ") 
                                AND m.userid=p.userid AND m.cuisinetype=p.cuisinetype AND (m.menutype=p.mealfor OR m.menutype=IF(p.mealfor!=0,3,0)) 
                                AND m.category!='Others' AND m.category!=IF(p.mealtype=1,'Veg','Non Veg')
                              GROUP BY m.category
                              ORDER BY m.id DESC
                            ")->results();
		
		if(count($res) > 0)
		{
            
            foreach($res as $value){
                /* $menuitems = $db->pdoQuery("select m.id as menu_id,m.itemname,m.itemprice 
                                        FROM mastermenu as m 
                                        WHERE m.id IN (SELECT menuid FROM weeklypackagemenu WHERE weeklypackageid=".$weekly_package_id.") 
                                        AND m.userid=".$value['userid']." AND m.cuisinetype=".$value['cuisinetype']." 
                                        AND (m.menutype=".$value['menutype']." OR m.menutype=IF(".$value['menutype']."!=0,3,0)) AND m.category='".$value['category']."'")->results(); */

                $menuitems = $db->pdoQuery("select m.id as menu_id,m.itemname,m.itemprice 
                                        FROM mastermenu as m 
                                        WHERE m.id IN (" . $value['menu_ids'] . ")")->results();
                
                $return_array[] = array(
                    "category" => $value['categoryname'],
                    "menuitems"=> $menuitems
                );
            }
        
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Menu item not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



