<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class My_account extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("User_model","User");
        $this->load->model("Order_model","Order");
    }

    public function index() {

        $title = "My Account";

        $this->viewData['page'] = "My_account";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "My_account";
        
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $this->viewData['kitchendata'] = $this->User->getUserDataByID($kitchenid);
		
        // $this->viewData['favorite_orderdata'] = $this->Order->getFoodiesFavoriteOrders($foodiesid);

        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }

    public function edit_profile() {

        $title = "Edit Profile";

        $this->viewData['page'] = "Edit_profile";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Edit_profile";

        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $this->load->model("Province_model","Province");
        $this->viewData['provincedata'] = $this->Province->getProvinceData(array("countryid"=>"101"),array("name"=>"ASC"));

        $this->viewData['kitchendata'] = $this->User->getUserDataByID($kitchenid);

        $this->kitchen_headerlib->add_stylesheet("bootstrap-datepickercss","bootstrap-datepicker.css");
        $this->kitchen_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/js/bootstrap-datepicker.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }

    public function update_profile(){
		
		$PostData = $this->input->post();
		$kitchenid = $this->session->userdata(base_url().'FRONTUSERID');
        // print_r($_FILES); print_r($PostData); exit;

		$kitchenname = trim($PostData['kitchenname']);
		$description = trim($PostData['description']);
		$email = trim($PostData['email']);
		$address = trim($PostData['address']);
		$state = trim($PostData['stateid']);
		$city = trim($PostData['cityid']);
		$pincode = trim($PostData['pincode']);
        $contactname = trim($PostData['contactname']);
        $role = trim($PostData['role']);
        $mobilenumber = trim($PostData['mobilenumber']);
        $kitchencontactnumber = trim($PostData['kitchencontactnumber']);
        $fssai = trim($PostData['fssai']);
        $expirydate = (trim($PostData['expirydate'])!="")?$this->general_model->convertdate(trim($PostData['expirydate'])):"";
        $panno = trim($PostData['panno']);
        $gstno = trim($PostData['gstno']);
        
		$oldmenufile = trim($PostData['oldmenufile']);
		$olddocumentfile = trim($PostData['olddocumentfile']);
		$oldprofile_image = trim($PostData['oldprofile_image']);
        $documentid = trim($PostData['documentid']);

		$modifieddate = $this->general_model->getCurrentDateTime();
		
		$Check = $this->User->CheckEmailAvailable($email,$kitchenid);

        if (empty($Check)) {

			$kitchen_address = $address;
			if($city){
				$this->load->model("City_model","City");
				$citydata = $this->City->getCityDataByID($city); 
				
				$kitchen_address .= ', '.$citydata['name'].', '.$citydata['state'];
			}
			$kitchen_address .= ' '.$pincode;
			$kitchen_address = str_replace(' ','+',$kitchen_address);
			
			$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($kitchen_address).'&sensor=false&key='.GOOGLE_MAP_API_KEY;
			$geocode = @file_get_contents($url);
			$output= json_decode($geocode);
			
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;
			

			if(!is_dir(DOCUMENT_PATH)){
				@mkdir(DOCUMENT_PATH);
			}
			if(!is_dir(MENU_PATH)){
				@mkdir(MENU_PATH);
			}
			if(!is_dir(USER_PROFILE_PATH)){
				@mkdir(USER_PROFILE_PATH);
			}

			$menufile = $oldmenufile;
			if(isset($_FILES['menufile']['name']) && $_FILES['menufile']['name']!=""){
				if(!empty($oldmenufile)){
                    $menufile = reuploadFile('menufile', 'IMG&PDF', $oldmenufile, MENU_PATH ,"*", '', 0);
				}else{
					$menufile = uploadFile('menufile', 'IMG&PDF' ,MENU_PATH ,"*", '', 0);
				}
				if($menufile !== 0){	
					if ($menufile == 2) {
						echo "Menu file not uploaded !";//FILE NOT UPLOADED
						exit;
					}
				}else{
					echo "Invalid menu file type !";//INVALID FILE TYPE
					exit;
				}
			}
            
			$documentfile = $olddocumentfile;
			if(isset($_FILES['documentfile']['name']) && $_FILES['documentfile']['name']!=""){
				if(!empty($olddocumentfile)){
					$documentfile = reuploadFile('documentfile', 'IMG&PDF', $olddocumentfile, DOCUMENT_PATH ,"*", '', 0);
				}else{
					$documentfile = uploadFile('documentfile', 'IMG&PDF' ,DOCUMENT_PATH ,"*", '', 0);
				}
				if($documentfile !== 0){	
					if ($documentfile == 2) {
						echo "Document file not uploaded !";//FILE NOT UPLOADED
						exit;
					}
				}else{
					echo "Invalid document file type !";//INVALID FILE TYPE
					exit;
				}
			}
			$profile_image = $oldprofile_image;
			if(isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name']!=""){
				if(!empty($oldprofile_image)){
					$profile_image = reuploadFile('profile_image', 'image', $oldprofile_image, USER_PROFILE_PATH ,"*", '', 0);
				}else{
					$profile_image = uploadFile('profile_image', 'image' ,USER_PROFILE_PATH ,"*", '', 0);
				}
				if($profile_image !== 0){	
					if ($profile_image == 2) {
						echo "Profile image not uploaded !";//FILE NOT UPLOADED
						exit;
					}
				}else{
					echo "Invalid profile image type !";//INVALID FILE TYPE
					exit;
				}
			}
			$updatedata = array("kitchenname"=>$kitchenname,
								"description"=>$description,
								"email"=>$email,
								"address"=>$address,
								"latitude"=>$latitude,
                    			"longitude"=>$longitude,
								"stateid"=>$state,
								"cityid"=>$city,
								"pincode"=>$pincode,
								"contactname"=>$contactname,
								"role"=>$role,
								"mobilenumber"=>$mobilenumber,
								"kitchencontactnumber"=>$kitchencontactnumber,
								"fssailicenceno"=>$fssai,
								"expirydate"=>$expirydate,
								"panno"=>$panno,
								"gstno"=>$gstno,
								"menufile"=>$menufile,
								"profile_image"=>$profile_image,
								"modifieddate"=>$modifieddate
							);

			$this->User->_where = array("id"=>$kitchenid);
			$this->User->Edit($updatedata);

            $this->User->_table = 'userdocuments';
            
            if($documentid!="" && !empty($olddocumentfile)){
                $doucment_array = array("file"=>$documentfile);
                
                $this->User->_where = array("id"=>$documentid);
                $this->User->Edit($doucment_array);
            }else{
                $doucment_array = array("userid"=>$kitchenid,"file"=>$documentfile);
                
                $this->User->Add($doucment_array);
            }

			$userdata = array(
				base_url().'FRONTKITCHENPROFILEIMAGE' => $profile_image,
			);
			$this->session->set_userdata($userdata);

			echo 1;
		}else{
			echo 2;//STAFF EMAIL OR MOBILE DUPLICATE
		}
	}

	public function update_account_detail(){
		
		$PostData = $this->input->post();
		$kitchenid = $this->session->userdata(base_url().'FRONTUSERID');
     
		$firmtype = trim($PostData['firmtype']);
		$foodtype = implode(",",$PostData['foodtype']);
		$fromtime = trim($PostData['fromtime']);
		$totime = trim($PostData['totime']);
		$opendays = implode(",",$PostData['opendays']);
		$mealtype = implode(",",$PostData['mealtype']);
		$modifieddate = $this->general_model->getCurrentDateTime();

		$updatedata = array("firmtype"=>$firmtype,
							"foodtype"=>$foodtype,
							"fromtime"=>$fromtime,
							"totime"=>$totime,
							"opendays"=>$opendays,
							"mealtype"=>$mealtype,
							"modifieddate"=>$modifieddate
						);

		$this->User->_where = array("id"=>$kitchenid);
		$this->User->Edit($updatedata);
		
		echo 1;
	}

	public function update_account_setting(){
		
		$PostData = $this->input->post();
		$kitchenid = $this->session->userdata(base_url().'FRONTUSERID');
     
		$kitchenname = trim($PostData['kitchenname']);
		$address = trim($PostData['address']);
		$email = trim($PostData['email']);
		$mobilenumber = trim($PostData['mobilenumber']);
		$password = trim($PostData['password']);
		$description = trim($PostData['description']);
		$oldprofile_image = trim($PostData['oldprofile_image']);
		$modifieddate = $this->general_model->getCurrentDateTime();

		$Check = $this->User->CheckEmailAvailable($email,$kitchenid);

        if (empty($Check)) {

			$kitchen_address = str_replace(' ','+',$address);
			
			$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($kitchen_address).'&sensor=false&key='.GOOGLE_MAP_API_KEY;
			$geocode = @file_get_contents($url);
			$output= json_decode($geocode);
			
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;

			$profile_image = $oldprofile_image;
			if(isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name']!=""){
				if(!empty($oldprofile_image)){
					$profile_image = reuploadFile('profile_image', 'image', $oldprofile_image, USER_PROFILE_PATH ,"*", '', 0);
				}else{
					$profile_image = uploadFile('profile_image', 'image' ,USER_PROFILE_PATH ,"*", '', 0);
				}
				if($profile_image !== 0){	
					if ($profile_image == 2) {
						echo "Profile image not uploaded !";//FILE NOT UPLOADED
						exit;
					}
				}else{
					echo "Invalid profile image type !";//INVALID FILE TYPE
					exit;
				}
			}

			$updatedata = array("kitchenname"=>$kitchenname,
								"address"=>$address,
								"latitude"=>$latitude,
                    			"longitude"=>$longitude,
								"email"=>$email,
								"mobilenumber"=>$mobilenumber,
								"description"=>$description,
								"password"=>$password,
								"profile_image"=>$profile_image,
								"modifieddate"=>$modifieddate
							);

			$this->User->_where = array("id"=>$kitchenid);
			$this->User->Edit($updatedata);
		
			$userdata = array(
				base_url().'FRONTKITCHENNAME' => $kitchenname,
				base_url().'FRONTKITCHENADDRESS' => $address,
				base_url().'FRONTUSEREMAIL' => $email,
				base_url().'FRONTKITCHENPROFILEIMAGE' => $profile_image
			);
			$this->session->set_userdata($userdata);

			echo 1;
		}else{
			echo 2;//EMAIL DUPLICATE
		}
	}
}