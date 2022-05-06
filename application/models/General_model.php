<?php

class General_model extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->db->query("SET time_zone = '+0:00'");
    }
    function encryptIt($q){
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
        return( $qEncoded );
    }
    function decryptIt($q){
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
        return( $qDecoded );
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
    function getCurrentDateTime() {
       date_default_timezone_set('Asia/Kolkata');

        return date('Y-m-d H:i:s');
    }
    function getCurrentDate() {
       date_default_timezone_set('Asia/Kolkata');

        return date('Y-m-d');
    }
    function convertdate($date,$output_format = 'Y-m-d'){
        return date($output_format,strtotime(str_replace('/', '-',$date)));
    }
    function displaydate($date,$output_format = 'd/m/Y'){
        return date($output_format,strtotime(str_replace('/', '-',$date)));
    }
    function convertdatetime($datetime){
        return date('Y-m-d H:i:s',strtotime(str_replace('/', '-',$datetime)));
    }
    function displayapidate($date){
        return date('j-M-Y',strtotime(str_replace('/', '-',$date)));
    }
    function displaydatetime($datetime){
        return date_format(date_create($datetime), 'd M Y h:i A');
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
    function resizeimage($path, $file, $width, $height){

        $config['image_library'] = 'gd2';
        $config['source_image'] = $path.$file;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;

        $this->load->library('image_lib');
        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        $this->image_lib->resize();
        
        @unlink($path.$file);
        $temp = explode('.', $file );
        $extension = array_pop($temp);
        $name = preg_replace("/[^a-zA-Z0-9-]/", "-",implode('.', $temp ));
        $file = $name.".".$extension;
        rename($path.$name."_thumb.".$extension, $path.$file);

    }

   
    function getYoutubevideoThumb($url) {

        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", urldecode($url), $matches);
        return '//img.youtube.com/vi/'.$matches[1].'/mqdefault.jpg';
    }

    function compress($source, $destination, $quality=80) {
        $info = getimagesize($source);
    
        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/pjpeg') {
            try{
                $image = imagecreatefromjpeg($source);
                @unlink($source);
                imagejpeg($image, $destination, $quality);
            } catch(Exception $e){
                echo $source.' : '.$e->getMessage().'<br>';
            }
        }elseif ($info['mime'] == 'image/gif') {
            try{
                $image = imagecreatefromgif($source);
                @unlink($source);
                imagegif($image, $destination, $quality);
            } catch(Exception $e){
                echo $source.' : '.$e->getMessage().'<br>';
            }
        }elseif ($info['mime'] == 'image/png' || $info['mime'] == 'x-png') {
            try{
                $image = imagecreatefrompng($source);
                @unlink($source);
                imagepng($image, $destination, 7);
            } catch (Exception $e){
                echo $source.' : '.$e->getMessage().'<br>';
            }
        }
        
        return $destination;
    }
    function random_strings($length_of_string) 
    { 
      
        // String of all alphanumeric character 
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
      
        // Shufle the $str_result and returns substring 
        // of specified length 
        return substr(str_shuffle($str_result), 0, $length_of_string); 
    } 
  
	function validateemailaddress($email) {
		if(!empty($email)) {
			$domain = $this->validateDomain($email);
			$validate = $this->validateEmail($email);
	
			if($domain == false || $validate == false) {
				return false;
			}
        }
        return true;
	}

	function validateEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}

	function validateDomain($mail){
		$domain = explode('@',$mail);
		
		if(empty($mail) || empty($domain[1])){
			return false;
			die;
		}		 
		
		$handle = curl_init($domain[1]);
		curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

		// Get the HTML or whatever is linked in $url. 
		$response = curl_exec($handle);
	
		// Check for 404 (file not found). 
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

		curl_close($handle);
		if(empty($response) || empty($httpCode) || $httpCode == 404) {
			return false;
		}else{
			return true;		
		}
	}
    function get_m3u8_video_segment($url) {
        $m3u8 = file_get_contents($url);
        if (strlen($m3u8) > 3) {
          $tmp =  strrpos($url, '/');
          if ($tmp !== false) {
            $base_url = substr($url, 0, $tmp + 1);
            if (filter_var($base_url, FILTER_VALIDATE_URL)) {
              $array = preg_split('/\s*\R\s*/m', trim($m3u8), NULL, PREG_SPLIT_NO_EMPTY);
              $url2 = array();
              foreach ($array as $line) {
                $line = trim($line);
                if (strlen($line) > 2) {
                  if ($line[0] != '#') {
                    if (filter_var($line, FILTER_VALIDATE_URL)) {
                      $url2[] = $line;
                    } else {
                      $url2[] = $base_url . $line;
                    }                    
                  }
                }
              }
              return $url2;
            }
          }
        }
        return false;
    }


    // PHP program to convert timestamp
    // to time ago
    function time_Ago($time) {

        // Calculate difference between current
        // time and given timestamp in seconds
        $diff	 = time() - $time;
        
        // Time difference in seconds
        $sec	 = $diff;
        
        // Convert time difference in minutes
        $min	 = round($diff / 60 );
        
        // Convert time difference in hours
        $hrs	 = round($diff / 3600);
        
        // Convert time difference in days
        $days	 = round($diff / 86400 );
        
        // Convert time difference in weeks
        $weeks	 = round($diff / 604800);
        
        // Convert time difference in months
        $mnths	 = round($diff / 2600640 );
        
        // Convert time difference in years
        $yrs	 = round($diff / 31207680 );
        
        // Check for seconds
        if($sec <= 60) {
            $time_ago = "$sec seconds ago";
        }
        
        // Check for minutes
        else if($min <= 60) {
            if($min==1) {
                $time_ago = "one minute ago";
            }
            else {
                $time_ago = "$min minutes ago";
            }
        }
        
        // Check for hours
        else if($hrs <= 24) {
            if($hrs == 1) {
                $time_ago = "an hour ago";
            }
            else {
                $time_ago = "$hrs hours ago";
            }
        }
        
        // Check for days
        else if($days <= 7) {
            if($days == 1) {
                $time_ago = "Yesterday";
            }
            else {
                $time_ago = "$days days ago";
            }
        }
        
        // Check for weeks
        else if($weeks <= 4.3) {
            if($weeks == 1) {
                $time_ago = "a week ago";
            }
            else {
                $time_ago = "$weeks weeks ago";
            }
        }
        
        // Check for months
        else if($mnths <= 12) {
            if($mnths == 1) {
                $time_ago = "a month ago";
            }
            else {
                $time_ago = "$mnths months ago";
            }
        }
        
        // Check for years
        else {
            if($yrs == 1) {
                $time_ago = "one year ago";
            }
            else {
                $time_ago = "$yrs years ago";
            }
        }

        return $time_ago;
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
}

?>