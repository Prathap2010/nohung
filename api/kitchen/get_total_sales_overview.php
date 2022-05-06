<?php
include_once("../include/config.php");


function weeks_in_month($month, $year) {
    // Start of month
    $start = mktime(0, 0, 0, $month, 1, $year);
    // End of month
    $end = mktime(0, 0, 0, $month, date('t', $start), $year);
    // Start week
    $start_week = date('W', $start);
    // End week
    $end_week = date('W', $end);
   
    if ($end_week < $start_week) { // Month wraps
      return ((52 + $end_week) - $start_week) + 1;
    }
   
    return ($end_week - $start_week) + 1;
}
function getStartAndEndDate($week, $year) {
    $dateTime = new DateTime();
    $dateTime->setISODate($year, $week);
    $result['start_date'] = $dateTime->format('Y-m-d');
    $dateTime->modify('+6 days');
    $result['end_date'] = $dateTime->format('Y-m-d');
    return $result;
}

  
extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0 && $month > 0 && $year > 0){

        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        $res = $db->pdoQuery("SELECT SUM(netamount) as total
                              FROM orders AS o
							  WHERE DATE_FORMAT(o.createddate, '%m') = '".$month."' AND DATE_FORMAT(o.createddate, '%Y') = '".$year."' AND o.userid = ".$kitchen_id."
                            ")->result();

        $total_earn = number_format($res['total'],2,'.','');
        
        
        $weeks_in_month = weeks_in_month($month, $year);

        $week = array();
        $day = '01';
        for($i=1; $i<=$weeks_in_month; $i++){

            $weeks_number = date("W", strtotime($year.'-'.$month.'-'.$day));
            $week_date = getStartAndEndDate($weeks_number, $year);
            
            $res = $db->pdoQuery("SELECT SUM(netamount) as total
                                  FROM orders AS o
                                  WHERE DATE_FORMAT(o.createddate, '%m') = '".$month."' AND DATE_FORMAT(o.createddate, '%Y') = '".$year."' AND (date(o.createddate) BETWEEN '".$week_date['start_date']."' AND '".$week_date['end_date']."') AND o.userid = ".$kitchen_id."
                                ")->result();
    
            $total_weekly_earn = number_format($res['total'],2,'.','');


            $week["week".$i] = $total_weekly_earn;

            $day += '7';
        }


        $return_array = array(
            "total_earn" => $total_earn,
            "total_earn_per_week" => $week,
        );

		APIsuccess("success",$return_array);

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



