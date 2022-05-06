<?php
	
 	/* Used to upload a new image and remove old image */

	function reuploadfile($ElementFileName, $imageType, $delete, $destination, $allowextension='*', $setfilename='', $filecompress=0, $width='', $height=''){
		$str = uploadFile($ElementFileName, $imageType, $destination, $allowextension, $setfilename, $filecompress, $width, $height);
		if($str !== 0){
			unlinkfile($delete, $destination);
			return $str;
		} else {
			return 0;
		}
	}

	/* Used to remove old file */

	function unlinkfile($delete, $destination){
		@unlink($destination.$delete);
	}
	
	/* Used to uplaod any file */
	
	function uploadFile($ElementFileName, $imageType, $destination, $allowextension='*', $setfilename='', $filecompress=0, $width='', $height='',$upload=1){
		$str = "";

		$File = $_FILES[$ElementFileName]["name"];
		
		$fileName = $File; 
		$fileTmpLoc = $_FILES[$ElementFileName]["tmp_name"];
		$temp = explode(".", $File);
		
		$extension = end($temp);
		$temp = explode('.', $fileName);
		$ext = strtolower(array_pop($temp));
		$name = preg_replace("/[^a-zA-Z0-9-]/", "",implode('.', $temp ));
		$time1 = time();
		
		if($setfilename!=''){
			$FileNM = $setfilename.".".$extension;
		}else{
			$FileNM = $name.$time1.".".$extension;
		}
		
		if($imageType == "PROFILE" || $imageType == "SETTINGS" || $imageType == "image"){
			$str = validateImage($fileTmpLoc, $ext);
		}else if($imageType == "VIDEO_FILE"){
			$str = validateVideo($fileTmpLoc, $ext);
		}else if($imageType == "IMG&PDF"){
			$extensions = array("pdf");
			$validPdfExt = in_array($ext, $extensions, true);

			if($validPdfExt){
				$str = validatePdf($fileTmpLoc, $ext);
			}else{
				$str = validateImage($fileTmpLoc, $ext);
			}
		}else if($imageType == "SUBTITLE_FILE"){
			$str = validateSRTFile($fileTmpLoc, $ext);
		}
		
		if($str){
			if($upload==1){
				$ci = get_instance();
				$ci->load->library('upload');
				if(!is_dir($destination)){
					@mkdir($destination);
				}
				$uploadData = array(
					'allowed_types'		=> $allowextension,
					'file_name'			=> $FileNM,
					'upload_path'		=> $destination,
				);
				$ci->upload->initialize($uploadData);
				if (!$ci->upload->do_upload($ElementFileName)) {
					return 2;//file not uploaded
				}
				if($filecompress==1){
					compress($destination.$FileNM,$destination.$FileNM,80);
				}
				if($width!='' && $height!=''){

					$temp = explode('.', $FileNM);
					$extension = end($temp);

					$image_info = getimagesize($_FILES[$ElementFileName]["tmp_name"]);
					$image_width = $image_info[0];
					$image_height = $image_info[1];
					
					if ($image_width != $width || $image_height != $height) {
						$config['image_library'] = 'gd2';
						$config['source_image'] = $destination.$FileNM;
						$config['create_thumb'] = true;
						$config['maintain_ratio'] = true;
						$config['width'] = $width;
						$config['height'] = $height;

						$ci->load->library('image_lib');
						$ci->image_lib->clear();
						$ci->image_lib->initialize($config);

						$ci->image_lib->resize();
						
						@unlink($destination.$FileNM);
						$temp = explode('.', $FileNM);
						$extension = array_pop($temp);
						$name = preg_replace("/[^a-zA-Z0-9-]/", "-", implode('.', $temp));
						$file = $name.".".$extension;
						rename($destination.$name."_thumb.".$extension, $destination.$file);
					}
				}
			}
			return $FileNM;
		} else {
			return 0;
		}
	}
	/* Use to Check uplaod file is Image or not */
	function validateImage($file, $ext){
		$mime_types = array(
			"bmp" => array("image/bmp", "image/x-windows-bmp"),
			"bm" => array("image/bmp"),
			"gif" => array("image/gif"),
			"ico" => array("image/x-icon"),
			"jfif" => array("image/jpeg", "image/pjpeg"),
			"jfif-tbnl" => array("image/jpeg"),
			"jpe" => array("image/jpeg", "image/pjpeg"),
			"jpeg" => array("image/jpeg", "image/pjpeg"),
			"jpg" => array("image/jpeg", "image/pjpeg","image/jpeg"),
			"pbm" => array("image/x-portable-bitmap"),
			"png" => array("image/png","image/jpeg"),
			"svf" => array("image/vnd.dwg", "image/x-dwg"),
			"tif" => array("image/tiff", "image/x-tiff"),
			"tiff" => array("image/tiff", "image/x-tiff"),
			"wbmp" => array("image/vnd.wap.wbmp"),
			"x-png" => array("image/png")
		);
		$extensions = array_keys($mime_types);
		$validMimeType = false;
		$ext = strtolower($ext);
		if(function_exists('mime_content_type')){

			$msg = mime_content_type($file);
			
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $msg){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			$validExt = in_array($ext, $extensions, true);
			
			if($validMimeType && $validExt){
				return 1;
			} else {
				return 0;
			}
		} else if(!function_exists('mime_content_type')) {
			if (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $file);
				finfo_close($finfo);
				$value = $mimetype;
			} else if (!stristr(ini_get("disable_functions"), "shell_exec")) {
				$file = escapeshellarg($file);
				$mime = shell_exec("file -bi " . $file);
				$value = $mime;
			} else {
				$value = 'application/octet-stream';
			}
			
			$value = explode(';',$value);
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $value[0]){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			
			if($validMimeType){
				return 1;
			} else {
				return 0;
			}
		}
	}
	/*function validateCsv($file, $ext){
		$mime_types = array(
			"csv" => array("text/csv","text/plain")
		);
		$extensions = array_keys($mime_types);

		if(function_exists('mime_content_type')){
			$msg = mime_content_type($file);
			
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $msg){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			$validExt = in_array($ext, $extensions, true);
			
			if($validMimeType && $validExt){
				return 1;
			} else {
				return 0;
			}
		} else if(!function_exists('mime_content_type')) {
			if (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $file);
				finfo_close($finfo);
				$value = $mimetype;
			} else if (!stristr(ini_get("disable_functions"), "shell_exec")) {
				$file = escapeshellarg($file);
				$mime = shell_exec("file -bi " . $file);
				$value = $mime;
			} else {
				$value = 'application/octet-stream';
			}
			
			$value = explode(';',$value);
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $value[0]){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			
			if($validMimeType){
				return 1;
			} else {
				return 0;
			}
    	}
	}*/
	
	/* Use to Check uplaod file is Excel or not */	
	function validateExcel($file, $ext){
		$mime_types = array(
			"ods" => array("application/vnd.oasis.opendocument.spreadsheet"),
			"xl" => array("application/excel"),
			"xlc" => array("application/excel"),
			"xls" => array("application/excel", "application/vnd.ms-excel", "application/x-excel", "application/x-msexcel", "application/vnd.ms-office", "application/octet-stream","application/vnd.oasis.opendocument.spreadsheet","application/msword"),
			"xlsx" => array("application/octet-stream", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel","application/vnd.oasis.opendocument.spreadsheet","application/zip")
		);
		$extensions = array_keys($mime_types);
		
		if(function_exists('mime_content_type')){
			$msg = mime_content_type($file);
			
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $msg){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			$validExt = in_array($ext, $extensions, true);
			
			if($validMimeType && $validExt){
				return 1;
			} else {
				return 0;
			}
		} else if(!function_exists('mime_content_type')) {
			if (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $file);
				finfo_close($finfo);
				$value = $mimetype;
			} else if (!stristr(ini_get("disable_functions"), "shell_exec")) {
				$file = escapeshellarg($file);
				$mime = shell_exec("file -bi " . $file);
				$value = $mime;
			} else {
				$value = 'application/octet-stream';
			}
			
			$value = explode(';',$value);
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $value[0]){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			
			if($validMimeType){
				return 1;
			} else {
				return 0;
			}
		}
	}

	/* Use to Check uplaod file is video or not */
	function validateVideo($file, $ext){
		$mime_types = array(
			"avi" => array("application/x-troff-msvideo", "video/avi", "video/x-msvideo"),
			"mjpg" => array("video/x-motion-jpeg"),
			"moov" => array("video/quicktime"),
			"mov" => array("video/quicktime"),
			"mpeg" => array("video/mpeg"),
			"mpg" => array("video/mpeg"),
			"mpeg4" => array("video/mpeg4"),
			"webm" => array("video/webm"),
			"mpegps" => array("video/mpegps"),
			"mv" => array("video/x-sgi-movie"),
			"flv" => array("video/x-flv"),
			"mp4" => array("video/mp4","video/3gpp"),
			"3gp" => array("video/3gpp","application/octet-stream"),
			"3gpp" => array("video/3gpp"),
			"m3u8" => array("application/x-mpegURL"),
			"ts" => array("video/MP2T"),
			"wmv" => array("video/x-ms-wmv","video/x-ms-wmv"),
			"mkv" => array("video/x-matroska")
		);
		$extensions = array_keys($mime_types);

		$validMimeType = false;
		if(function_exists('mime_content_type')){
			$msg = mime_content_type($file);
			// echo $msg; exit;
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $msg){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			$validExt = in_array($ext, $extensions, true);
			
			if($validMimeType && $validExt){
				return 1;
			} else {
				return 0;
			}
		} else if(!function_exists('mime_content_type')) {
			if (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $file);
				finfo_close($finfo);
				$value = $mimetype;
			} else if (!stristr(ini_get("disable_functions"), "shell_exec")) {
				$file = escapeshellarg($file);
				$mime = shell_exec("file -bi " . $file);
				$value = $mime;
			} else {
				$value = 'application/octet-stream';
			}
			
			$value = explode(';',$value);
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $value[0]){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			
			if($validMimeType){
				return 1;
			} else {
				return 0;
			}
    	}
	}

	function validatePdf($file, $ext){
		$mime_types = array(
			"pdf" => array('application/pdf','application/octet-stream'),
		);
		$extensions = array_keys($mime_types);

		if(function_exists('mime_content_type')){
			$msg = mime_content_type($file);
			$validMimeType = false;
			
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $msg){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			$validExt = in_array($ext, $extensions, true);
			
			if($validMimeType && $validExt){
				return 1;
			} else {
				return 0;
			}
		} else if(!function_exists('mime_content_type')) {
			if (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $file);
				finfo_close($finfo);
				$value = $mimetype;
			} else if (!stristr(ini_get("disable_functions"), "shell_exec")) {
				$file = escapeshellarg($file);
				$mime = shell_exec("file -bi " . $file);
				$value = $mime;
			} else {
				$value = 'application/octet-stream';
			}
			
			$value = explode(';',$value);
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $value[0]){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			
			if($validMimeType){
				return 1;
			} else {
				return 0;
			}
    	}
	}
	function validateZip($file, $ext){
		$mime_types = array(
			"zip" => array("application/zip")
		);
		$extensions = array_keys($mime_types);

		if(function_exists('mime_content_type')){
			$msg = mime_content_type($file);
			
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $msg){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			$validExt = in_array($ext, $extensions, true);
			
			if($validMimeType && $validExt){
				return 1;
			} else {
				return 0;
			}
		} else if(!function_exists('mime_content_type')) {
			if (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $file);
				finfo_close($finfo);
				$value = $mimetype;
			} else if (!stristr(ini_get("disable_functions"), "shell_exec")) {
				$file = escapeshellarg($file);
				$mime = shell_exec("file -bi " . $file);
				$value = $mime;
			} else {
				$value = 'application/octet-stream';
			}
			
			$value = explode(';',$value);
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $value[0]){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			
			if($validMimeType){
				return 1;
			} else {
				return 0;
			}
    	}
	}
	function validateSRTFile($file, $ext){
		$mime_types = array(
			"srt" => array('text/plain'),
		);
		$extensions = array_keys($mime_types);

		if(function_exists('mime_content_type')){
			$msg = mime_content_type($file);
			$validMimeType = false;
			
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $msg){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			$validExt = in_array($ext, $extensions, true);
			
			if($validMimeType && $validExt){
				return 1;
			} else {
				return 0;
			}
		} else if(!function_exists('mime_content_type')) {
			if (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $file);
				finfo_close($finfo);
				$value = $mimetype;
			} else if (!stristr(ini_get("disable_functions"), "shell_exec")) {
				$file = escapeshellarg($file);
				$mime = shell_exec("file -bi " . $file);
				$value = $mime;
			} else {
				$value = 'text/plain';
			}
			
			$value = explode(';',$value);
			for($k = 0; $k < count($mime_types); $k++){
				if($extensions[$k] == $ext){
					for($i = 0; $i < count($mime_types[$ext]); $i++){
						if($mime_types[$ext][$i] == $value[0]){
							$validMimeType = true;
							break;
						} else {
							$validMimeType = false;
						}
					}
				}
			}
			
			if($validMimeType){
				return 1;
			} else {
				return 0;
			}
    	}
	}
	/* Use to Compress image size */
	function compress($source, $destination, $quality=80) {

		ob_start();
		$info = getimagesize($source);
	
		if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/pjpeg') {
			try{
				$image = imagecreatefromjpeg($source);
				unlinkfile('', '', $source);
				imagejpeg($image, $destination, $quality);
			} catch(Exception $e){
				echo $source.' : '.$e->getMessage().'<br>';
			}
		} elseif ($info['mime'] == 'image/gif') {
			try{
				$image = imagecreatefromgif($source);
				unlinkfile('', '', $source);
				imagegif($image, $destination, $quality);
			} catch(Exception $e){
				echo $source.' : '.$e->getMessage().'<br>';
			}
		} elseif ($info['mime'] == 'image/png' || $info['mime'] == 'x-png') {
			try{
				$image = imagecreatefrompng($source);
				unlinkfile('', '', $source);
				imagepng($image, $destination, 7);
			} catch (Exception $e){
				echo $source.' : '.$e->getMessage().'<br>';
			}
		}
		
		return $destination;
	}
?>