<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_setting extends Admin_Controller {

	public $viewData = array();
	function __construct(){
		parent::__construct();
		$this->viewData = $this->getUserSettings('Site_setting');
		$this->load->model('Site_setting_model','Setting');
	}
	public function index()
	{
		$this->viewData['title'] = "Site Setting";
		$this->viewData['module'] = "Site_setting";
		
        $this->viewData['settingdata'] = $this->Setting->getsitesetting();
		
        $this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
    public function update_settings()
	{
        $sitename = $_REQUEST['sitename'];
        $email = $_REQUEST['email'];
        $mapapikey = trim($_REQUEST['mapapikey']);
        $taxonorder = $_REQUEST['taxonorder'];
        $delivery_charge_per_km = $_REQUEST['delivery_charge_per_km'];
        $radius_in_km = $_REQUEST['radius_in_km'];
        $points_per_km = $_REQUEST['points_per_km'];
        
        $oldlogo = $_REQUEST['oldlogo'];
        $portemail = $_REQUEST['portemail'];
        $password = $_REQUEST['password'];
        $portno = $_REQUEST['portno'];
        $mailserver = $_REQUEST['mailserver'];
        $mailhost = $_REQUEST['mailhost'];
        $facebook_app_id = $_REQUEST['facebook_app_id'];
        $facebook_app_secret = $_REQUEST['facebook_app_secret'];
        $google_client_id = $_REQUEST['google_client_id'];
        $google_client_secret = $_REQUEST['google_client_secret'];
        $google_api_key = $_REQUEST['google_api_key'];

        $twitterlink = $_REQUEST['twitterlink'];
        $facebooklink = $_REQUEST['facebooklink'];
        $instagramlink = $_REQUEST['instagramlink'];

        if($_FILES["logo"]['name'] != ''){
            if($oldlogo==""){
                $FileNM1 = uploadfile('logo', 'SETTINGS', SETTING_PATH, "jpeg|png|jpg|ico|JPEG|PNG|JPG");
            }else{
                $FileNM1 = reuploadfile('logo', 'SETTINGS', $oldlogo, SETTING_PATH, "jpeg|png|jpg|ico|JPEG|PNG|JPG");
            }
            if($FileNM1 !== 0){	
                if($FileNM1==2){
                    echo 2; exit;
                }
            }else{
                echo 3; exit;
            }
        }else{
            $FileNM1 = 	$oldlogo;
        }
        
        $updatedata=array('sitename'=>$sitename,
                        'email'=>$email,
                        'mapapikey'=>$mapapikey,
                        'taxonorder'=>$taxonorder,
                        'delivery_charge_per_km'=>$delivery_charge_per_km,
                        'radius_in_km'=>$radius_in_km,
                        'points_per_km'=>$points_per_km,
                        'logo'=>$FileNM1,
                        'portemail'=>$portemail,
                        'password'=>$password,
                        'portno'=>$portno,
                        'mailserver'=>$mailserver,
                        'mailhost'=>$mailhost,
                        'facebook_app_id'=>$facebook_app_id,
                        'facebook_app_secret'=>$facebook_app_secret,
                        'google_client_id'=>$google_client_id,
                        'google_client_secret'=>$google_client_secret,
                        'google_api_key'=>$google_api_key,
                        'twitterlink'=>$twitterlink,
                        'facebooklink'=>$facebooklink,
                        'instagramlink'=>$instagramlink,
                    );

        $this->Setting->_where = array('id'=>1);
        $this->Setting->Edit($updatedata);
        
		// $setting = $this->Setting->getsitesetting();
		$this->session->set_userdata(array(
				base_url().'SITE_NAME' => $sitename,
				base_url().'SITE_EMAIL' => $email,
				base_url().'SITE_LOGO' => $FileNM1
		));

        echo 1;
	}

}