<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->load->model("User_model","User");
    }

    public function index() {

        $title = "Register";

        $this->viewData['page'] = "register";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Register";

        $this->load->model("Province_model","Province");
        $this->viewData['provincedata'] = $this->Province->getProvinceData(array("countryid"=>"101"),array("name"=>"ASC"));

        $this->kitchen_headerlib->add_stylesheet("bootstrap-datepickercss","bootstrap-datepicker.css");
        $this->kitchen_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/js/bootstrap-datepicker.js");
        $this->load->view(KITCHENFOLDER . 'Register', $this->viewData);
    }

    public function new_register(){

		$PostData = $this->input->post();
		$kitchenname = trim($PostData['kitchenname']);
		$address = trim($PostData['address']);
        $email = trim($PostData['email']);
		$stateid = trim($PostData['stateid']);
		$cityid = trim($PostData['cityid']);
        $pincode = trim($PostData['pincode']);
        $contactname = trim($PostData['contactname']);
        $role = trim($PostData['role']);
        $mobilenumber = trim($PostData['mobilenumber']);
        $kitchencontactnumber = trim($PostData['kitchencontactnumber']);
        $fssai = trim($PostData['fssai']);
        $expirydate = (trim($PostData['expirydate'])!="")?$this->general_model->convertdate(trim($PostData['expirydate'])):"";
        $panno = trim($PostData['panno']);
        $gstno = trim($PostData['gstno']);

		$status = 0;
		$createddate = $this->general_model->getCurrentDateTime();
		
        $Check = $this->User->CheckEmailAvailable($email);
        
        if (empty($Check)) {
            $Check = $this->User->CheckMobileNumberAvailable($mobilenumber,0);
            if (empty($Check)) {
                if(!is_dir(MENU_PATH)){
                    @mkdir(MENU_PATH);
                }

                $filename = $_FILES['menufile']['name'];
                $filetmp =$_FILES['menufile']['tmp_name'];
                $extensions= array("jpeg","jpg","png","pdf");
                $menufile = "";

                if($filename != ''){

                    $fileext = explode('.',$filename)[1];
                    if(in_array($fileext,$extensions)=== true){
                        move_uploaded_file($filetmp,MENU_PATH.$filename);

                        $menufile = $filename;
                    }
                }
                $kitchen_address = $address;
                if($cityid){
                    $this->load->model("City_model","City");
                    $city = $this->City->getCityDataByID($cityid); 
                    
                    $kitchen_address .= ', '.$city['name'].', '.$city['state'];
                }
                $kitchen_address .= ' '.$pincode;
                $kitchen_address = str_replace(' ','+',$kitchen_address);
                
                $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($kitchen_address).'&sensor=false&key='.GOOGLE_MAP_API_KEY;
                $geocode = @file_get_contents($url);
                $output= json_decode($geocode);
                
                $latitude = $output->results[0]->geometry->location->lat;
                $longitude = $output->results[0]->geometry->location->lng;
                
                $insertdata = array("kitchenname"=>$kitchenname,
                    "email"=>$email,
                    "address"=>$address,
                    "latitude"=>$latitude,
                    "longitude"=>$longitude,
                    "stateid"=>$stateid,
                    "cityid"=>$cityid,
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
                    "userstatus"=>0,
                    "status"=>$status,
                    "createddate"=>$createddate,
                    "modifieddate"=>$createddate
                );
                
                
                $UserRegID = $this->User->Add($insertdata);
                // $UserRegID = 1;
                if($UserRegID){
                
                    $doucments=array();
                    // Count # of uploaded files in array
                    $total = count($_FILES['documents']['name']);
                    
                    if(!is_dir(DOCUMENT_PATH)){
                        @mkdir(DOCUMENT_PATH);
                    }
                    // Loop through each file
                    for( $i=0 ; $i < $total ; $i++ ) {

                        $file_name = $_FILES['documents']['name'][$i];
                        $file_tmp =$_FILES['documents']['tmp_name'][$i];
                        
                        if($file_name != ''){


                            $file_ext = explode('.',$file_name)[1];
        
                            if(in_array($file_ext,$extensions)=== true){
                                move_uploaded_file($file_tmp,DOCUMENT_PATH.$file_name);

                                $doucments[] = array("userid"=>$UserRegID,"file"=>$file_name);
                            }
                        }
                    }
                    if(!empty($doucments)){
                        $this->User->_table = 'userdocuments';
                        $this->User->add_batch($doucments);
                    }
                    // $userdata = $this->User->getUserDataByID($UserRegID);
                    duplicate : $KitchenID = time().$UserRegID;
                    $this->User->_table = 'user';
                    $check = $this->User->CheckKitchenIDAvailable($KitchenID);
                    if(!empty($check)){
                        goto duplicate;   
                    }
                    $Password = get_random_password(8,8,true,true,true);
                    
                    $this->User->_where = array("id"=>$UserRegID);
                    $this->User->Edit(array("kitchenid"=>$KitchenID,"password"=>$Password));

                    /* SEND EMAIL TO USER */
                    $MessageArr = array("{logo}" => '<a href="'.DOMAIN_URL.'"><img src="'.SETTING.SITE_LOGO.'" style="width:auto;height:60px;"></a>',
                                        "{kitchenname}" => $kitchenname,
                                        "{kitchenID}" => $KitchenID,
                                        "{password}" => $Password,
                                        "{sitename}"=>SITE_NAME,
                                        "{siteemail}"=>SITE_EMAIL,
                                    );
                    
                    $emailtype = array_search("Register", $this->Emailtype);
                    //Send mail with email format store in database
                    $this->User->sendMail($emailtype, $email, $MessageArr);
                    echo 1;
                }else{
                    echo 0;
                }
            }else{
                echo 3;
            }
        }else{
            echo 2;
        }
	}
}