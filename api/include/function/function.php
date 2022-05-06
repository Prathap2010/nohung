<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require_once("../include/config.php");

// require '../include/Twilio/autoload.php';
// use Twilio\Rest\Client;

function APIsuccess($msg = 'success',$data = array(),$current_page = '',$total_page = '',$total_records = '',$global_array = array())
{
    if($current_page != '' && $total_page != '' && $total_records != '')
    {
        if(empty($data) || count($data) <= 0 ){
            echo json_encode(array("status" => true, 
                               "message" => $msg, 
                               "current_page" => $current_page, 
                               "total_page" => $total_page, 
                               "total_records" => $total_records, 
                               "global" => $global_array), 
                        JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode(array("status" => true, 
                               "message" => $msg, 
                               "current_page" => $current_page, 
                               "total_page" => $total_page, 
                               "total_records" => $total_records, 
                               "global" => $global_array,
                               "data" => $data), 
                        JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }       
        exit;
    }
    else if($total_records != '')
    {

        if(count($global_array) > 0){
            echo json_encode(array("status"  => true,
                               "message" => $msg,
                               "total_records" => $total_records,
                               "global" => $global_array, 
                               "data" => $data), 
                        JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);exit;
        }else{
            echo json_encode(array("status"  => true,
            "message" => $msg,
            "total_records" => $total_records,
            "data" => $data), 
     JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);exit;
        }
        
    }
    else
    {

        if(count($global_array) > 0){
            echo json_encode(array("status"  => true,
                               "message" => $msg, 
                               "global" => $global_array,
                               "data" => $data), 
                        JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );exit;
        }else{
            echo json_encode(array("status"  => true,
                               "message" => $msg, 
                               "data" => $data), 
                        JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );exit;
        }
        
    }
}

function APIerror($msg = NRF, $data = array())
{
    echo json_encode(array("status" => false, "message" => $msg , "data" => array() ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function send_email($to,$sublect,$content){


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug  = 0;  
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "mail.notionprojects.tech";
    $mail->Username   = "mail@notionprojects.tech";
    $mail->Password   = "OzyRiqFf?+{(";

    $mail->IsHTML(true);
    $mail->AddAddress($to);
    $mail->SetFrom("mail@notionprojects.tech", "Nohung");
    $mail->Subject = $sublect;
    //$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

    $mail->MsgHTML($content); 
    if(!$mail->Send()) {
        return true;
    }

} 

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generate_otp($digits){
  return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
}

function humanTiming ($time)
{

    $time = strtotime($time);
    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
    }

}

function get_time_diff($date1,$date2){
    $time = abs(strtotime($date1) - strtotime($date2)) / 60;
    return round($time).'min';
}

function sendSMS($phone_no='',$msg=""){
    try{ 
            
        if (strpos($phone_no, '+') == false) {
            $phone_no = '+' . $phone_no; 
        }
        
        $sid = TWILIO_SID;
        $token = TWILIO_TOKEN;
        $client = new Twilio\Rest\Client($sid, $token);
        
        $message = $client->messages->create(
            $phone_no,
            array(
                'from' => TWILIO_PHONE_NO,
                'body' => $msg
            )
        );
        return true;
    } catch (Exception $e) {
        return false;
    } 
}

function encrypt($password) {
    $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
    $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
    $method = 'aes-256-cbc';

    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

    $encrypted = base64_encode(openssl_encrypt($password, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
    return $encrypted;
}

function decrypt($password) {
    $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
    $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
    $method = 'aes-256-cbc';

    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

    $decrypted = openssl_decrypt(base64_decode($password), $method, $sSalt, OPENSSL_RAW_DATA, $iv);
    return $decrypted;
}

function get_cuisinetype($cuisinetype){
    if($cuisinetype == 0){
        $cuisinetype = 'South Indian';
    }elseif($cuisinetype == 1){
        $cuisinetype = 'North Indian';
    }else{
        $cuisinetype = 'Other Cuisine';
    }

    return $cuisinetype;
}

function get_menutype($menutype){
    if($menutype == 0){
        $menutype = 'Breakfast';
    }elseif($menutype == 1){
        $menutype = 'Lunch';
    }else{
        $menutype = 'Dinner';
    }

    return $menutype;
}
function generate_random_number($len = 32) {

		// Array of potential characters, shuffled.
        $chars = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        );
		
		shuffle($chars);

		$num_chars = count($chars) - 1;
		$token = '';

		// Create random token at the specified length.
		for ($i = 0; $i < $len; $i++) {
			$token .= $chars[mt_rand(0, $num_chars)];
		}

		return $token;
}
function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
    $dates = [];
    $current = strtotime( $first );
    $last = strtotime( $last );

    while( $current <= $last ) {

        $dates[] = date( $format, $current );
        $current = strtotime( $step, $current );
    }

    return $dates;
}
function get_duration_between_two_places($GOOGLE_MAP_API_KEY,$origin,$destination,$output='duration',$return=0){
    
	/* In imperial unit
	$distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.urlencode($origin).'&destinations='.urlencode($destination).'&key=AIzaSyD6YkF-BVV1LNLOz5n3zeL9bi1farzUX8k');
	*/
	// In metric unit. This is default
	//mode (driving, walking, bicycling)

    
                        
	$distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.urlencode($origin).'&destinations='.urlencode($destination).'&mode=driving&key='.$GOOGLE_MAP_API_KEY);
	
	$distance_arr = json_decode($distance_data);
	// print_r($distance_arr); exit;
	if ($distance_arr->status=='OK') {
		$destination_addresses = $distance_arr->destination_addresses[0];
		$origin_addresses = $distance_arr->origin_addresses[0];
	} else {
		// return "The request was Invalid";
		exit();
	}
	if ($origin_addresses=="" or $destination_addresses=="") {
		// return "Destination or origin address not found";
		exit();
	}
	// Get the elements as array
	$elements = $distance_arr->rows[0]->elements;
    $duration = "";
    $distance = "0";
    if ($elements[0]->status == "OK") {
        $distance = $elements[0]->distance->text;
        $duration = $elements[0]->duration->text;
    }
	// echo "From: ".$origin_addresses."<br/> To: ".$destination_addresses."<br/> Distance: <strong>".$distance ."</strong><br/>";
	
	if($output == 'duration'){
		return $duration;
    } else if ($output == 'both') {
        $json = array('duration' => $duration, 'distance' => ($return == "0") ? $distance : explode(" ", $distance)[0]);
        return json_encode($json);
    }else{
		return ($return=="0") ? $distance : explode(" ",$distance)[0];
	}
}

function get_menu_image($image){
    if(file_exists(DIR_UPD.'menu/'.$image) && $image != ''){
        $image = SITE_UPD.'menu/'.$image;
    }else{
        $image = SITE_URL.'assets/image/noimage.jpg';
    }

    return $image;
}
?>