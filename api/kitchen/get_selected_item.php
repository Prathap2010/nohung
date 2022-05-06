<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0 && $package_id > 0){

        $res_pkg = $db->pdoQuery("SELECT * FROM packages as p WHERE p.id = ".$package_id)->result();

        $res = $db->pdoQuery("SELECT m.id,m.category,m.userid,m.cuisinetype,m.menutype
							  FROM mastermenu as m
                              INNER JOIN packages as p ON p.id=".$package_id."
                              WHERE m.userid=p.userid AND m.cuisinetype=p.cuisinetype AND m.menutype=p.mealfor AND m.category!='Others' AND m.category!=IF(p.mealtype=1,'Veg','Non Veg') AND m.id IN (SELECT menuid FROM weeklypackagemenu WHERE weeklypackageid='".$weekly_package_id."')
                              GROUP BY m.category
                              ORDER BY m.id DESC
                            ")->results();
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
              
                $menuitems = $db->pdoQuery("SELECT m.id as menu_id,m.itemname,m.itemprice,IF(wpm.qty > 0, wpm.qty, '') as qty
                                      FROM mastermenu as m
                                      INNER JOIN weeklypackagemenu as wpm ON wpm.weeklypackageid='".$weekly_package_id."' AND wpm.menuid=m.id
                                      WHERE m.userid=".$value['userid']." AND m.cuisinetype=".$value['cuisinetype']." AND m.menutype=".$value['menutype']." AND m.category='".$value['category']."'
                                    ")->results();

                $value['category'] = ($res_pkg['mealfor']==0)?($res_pkg['mealtype']==0?"Veg":"Non Veg"):$value['category'];

                $return_array[] = array(
                    "category"=>$value['category'],
					"menuitems" => $menuitems,
				);
			}
        }
        APIsuccess("success",$return_array);
    }else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}