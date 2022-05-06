<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($search_keyword != ""){

        $where = " (temp.itemname LIKE '%".$search_keyword."%') ";

		$res = $db->pdoQuery("SELECT temp.itemname
                    FROM (
						SELECT m.itemname

						FROM mastermenu as m
						INNER JOIN user as u ON u.id=m.userid
						LEFT JOIN province as p ON p.id=u.stateid
						LEFT JOIN city as c ON c.id=u.cityid
						WHERE u.status=1 AND u.usertype=0

						UNION 

						SELECT pkg.packagename as itemname

						FROM packages as pkg
						INNER JOIN user as u ON u.id=pkg.userid
						LEFT JOIN province as p ON p.id=u.stateid
						LEFT JOIN city as c ON c.id=u.cityid
						WHERE u.status=1 AND u.usertype=0

                    ) as temp WHERE ".$where."
                    GROUP BY temp.itemname
                    ORDER BY temp.itemname
                    ")->results();
		
		if(count($res) > 0)
		{   
            APIsuccess("success",$res);
		}
		else
		{
			APIError("Search results not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
	
}
else
{
	APIError("Token missing.");
}



