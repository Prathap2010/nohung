<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {

	public $viewData = array();
	function __construct(){
		parent::__construct();
		$this->viewData = $this->getUserSettings("User");
		$this->load->model('User_model','User');
	}
	public function index(){

		$this->viewData['title'] = "Kitchen";
		$this->viewData['module'] = "user/User";

		// $this->viewData['userdata'] = $this->User->getUserData();
		
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function get_user_list() {

        $list = $this->User->get_datatables();
        $data = array();
        $counter = $_POST['start'];
        
        foreach ($list as $datarow) {
            $row = array();
            $Action = '';
			$userstatus = "";
            
			if($datarow->userstatus==0){
				$userstatus = '<button class="btn btn-warning btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$datarow->id.'">Pending <span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu">
								<li id="dropdown-menu">
									<a onclick="chagestatus(1,'.$datarow->id.')">Approve</a>
								</li>
								<li id="dropdown-menu">
									<a onclick="chagestatus(2,'.$datarow->id.')">Reject</a>
								</li>
							</ul>';
			}else if($datarow->userstatus==1){
				$userstatus = '<button class="btn btn-success btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$datarow->id.'">Approved <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu">
					<li id="dropdown-menu">
						<a onclick="chagestatus(0,'.$datarow->id.')">Pending</a>
					</li>
					<li id="dropdown-menu">
						<a onclick="chagestatus(2,'.$datarow->id.')">Reject</a>
					</li>
				</ul>';
			}else if($datarow->userstatus==2){
				$userstatus = '<button class="btn btn-danger btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$datarow->id.'">Rejected <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu">
					<li id="dropdown-menu">
						<a onclick="chagestatus(0,'.$datarow->id.')">Pending</a>
					</li>
					<li id="dropdown-menu">
						<a onclick="chagestatus(1,'.$datarow->id.')">Approve</a>
					</li>
				</ul>';
			}
			
			$userstatus = '<div class="dropdown" style="float: left;">'.$userstatus.'</div>';
			
			$row[] = ++$counter;            
            $row[] = $datarow->kitchenname;
			$row[] = $datarow->kitchenid;
			$row[] = $datarow->email;
			$row[] = $datarow->address;
            $row[] = $datarow->state; 
			$row[] = $datarow->city;
			$row[] = $userstatus;
		    
			$Action .= '<a href="'.ADMIN_URL.'user/view-user/'.$datarow->id.'" class="'.view_class.'" title="'.view_title.'">'.view_text.'</a>';
			$Action .= '<a href="'.ADMIN_URL.'user/edit-user/'.$datarow->id.'" class="'.edit_class.'" title="'.edit_title.'">'.edit_text.'</a>';
			$Action .= '<a class="'.delete_class.'" href="javascript:void(0)" title="'.delete_title.'" onclick="deleterow('.$datarow->id.',\''.ADMIN_URL.'user/delete-user\')">'.delete_text.'</a>';
			if($datarow->status==1){ 
				$Action .= '<span id="span'.$datarow->id.'"><a href="javascript:void(0)" onclick="enabledisable(0,'.$datarow->id.',&quot;'.ADMIN_URL.'user/user-enable-disable&quot;,&quot;'.disable_title.'&quot;,&quot;'.disable_class.'&quot;,&quot;'.enable_class.'&quot;,&quot;'.disable_title.'&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_text.'&quot;,&quot;'.enable_text.'&quot;)" class="'.disable_class.'" title="'.disable_title.'">'.stripslashes(disable_text).'</a></span>';
			}else{
				$Action .= '<span id="span'.$datarow->id.'"><a href="javascript:void(0)" onclick="enabledisable(1,'.$datarow->id.',&quot;'.ADMIN_URL.'user/user-enable-disable&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_class.'&quot;,&quot;'.enable_class.'&quot;,&quot;'.disable_title.'&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_text.'&quot;,&quot;'.enable_text.'&quot;)" class="'.enable_class.'" title="'.enable_title.'">'.stripslashes(enable_text).'</a></span>';
			} 

            $row[] = $Action;
            $data[] = $row;

        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->User->count_all(),
                        "recordsFiltered" => $this->User->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);        
    }
	public function add_user() {

		$this->viewData['title'] = "Add Kitchen";
		$this->viewData['module'] = "user/Add_user";

		$this->load->model("Province_model","Province");
        $this->viewData['provincedata'] = $this->Province->getProvinceData(array("countryid"=>"101"),array("name"=>"ASC"));

		$this->admin_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/bootstrap-datepicker.js");
		$this->admin_headerlib->add_javascript("add_user","pages/add_user.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function user_add(){

		$PostData = $this->input->post();
		$kitchenname = trim($PostData['kitchenname']);
		$email = trim($PostData['email']);
		$address = trim($PostData['address']);
		$state = trim($PostData['state']);
		$city = trim($PostData['city']);
		$status = trim($PostData['status']);
		$createddate = $this->general_model->getCurrentDateTime();
		
		$Check = $this->User->CheckEmailAvailable($email);

        if (empty($Check)) {
			$insertdata = array("kitchenname"=>$kitchenname,
								"email"=>$email,
								"address"=>$address,
								"stateid"=>$state,
								"cityid"=>$city,
								"userstatus"=>1,
								"status"=>$status,
								"createddate"=>$createddate,
								"modifieddate"=>$createddate
							);
			
			$UserRegID = $this->User->Add($insertdata);
			
			if($UserRegID){
			
				// $userdata = $this->User->getUserDataByID($UserRegID);

				/* SEND EMAIL TO USER */
				// $MessageArr = array("{name}" => $firstname,"{username}" => $userdata['username']);
				
				// $emailtype = array_search("New User", $this->Emailtype);
				//Send mail with email format store in database
				// $this->User->sendMail($emailtype, $email, $MessageArr);
				echo 1;
			}else{
				echo 0;//STAFF DETAILS NOT INSERTED
			}
		}else{
			echo 2;//STAFF EMAIL OR MOBILE DUPLICATE
		}
	}
	public function edit_user($id){
		
		$this->viewData['title'] = "Edit Kitchen";
		$this->viewData['module'] = "user/Add_user";
		$this->viewData['action'] = "1";

		$this->viewData['userdata'] = $this->User->getUserDataByID($id);
		
		$this->load->model("Province_model","Province");
        $this->viewData['provincedata'] = $this->Province->getProvinceData(array("countryid"=>"101"),array("name"=>"ASC"));
        
		$this->admin_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/bootstrap-datepicker.js");
		$this->admin_headerlib->add_javascript("edit_user","pages/add_user.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function update_user(){
		
		$PostData = $this->input->post();
		$UserID = trim($PostData['userid']);
		$kitchenname = trim($PostData['kitchenname']);
		$email = trim($PostData['email']);
		$address = trim($PostData['address']);
		$state = trim($PostData['state']);
		$city = trim($PostData['city']);
		$status = trim($PostData['status']);
		
		$pincode = trim($PostData['pincode']);
        $contactname = trim($PostData['contactname']);
        $role = trim($PostData['role']);
        $mobilenumber = trim($PostData['mobilenumber']);
        $kitchencontactnumber = trim($PostData['kitchencontactnumber']);
        $fssai = trim($PostData['fssailicenceno']);
        $expirydate = (trim($PostData['expirydate'])!="")?$this->general_model->convertdate(trim($PostData['expirydate'])):"";
        $panno = trim($PostData['panno']);
        $gstno = trim($PostData['gstno']);
		$oldmenufile = trim($PostData['oldmenufile']);
		$olddocumentfile = trim($PostData['olddocumentfile']);
		$oldprofile_image = trim($PostData['oldprofile_image']);
		$description = trim($PostData['description']);
		$modifieddate = $this->general_model->getCurrentDateTime();
		
		$Check = $this->User->CheckEmailAvailable($email,$UserID);

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
								"email"=>$email,
								"description"=>$description,
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
								"status"=>$status,
								"modifieddate"=>$modifieddate
							);

			$this->User->_where = array("id"=>$UserID);
			$this->User->Edit($updatedata);

			$doucment_array = array("userid"=>$UserID,"file"=>$documentfile);

			$this->User->_table = 'userdocuments';
			$this->User->Add($doucment_array);

			echo 1;
		}else{
			echo 2;//STAFF EMAIL OR MOBILE DUPLICATE
		}
	}
	public function user_enable_disable(){
		$val = (isset($_REQUEST['val']))?$_REQUEST['val']:'';
		$id = (isset($_REQUEST['id']))?$_REQUEST['id']:'';
		$updatedata = array('status'=>$val);
		$this->User->_where = "id=".$id;
		$result=$this->User->Edit($updatedata);
		if($result){
			echo $id;
		}
	}
	public function view_user($id){

		$this->viewData['title'] = "View Kitchen";
        $this->viewData['module'] = "user/View_user";

        $this->viewData['userdata'] = $this->User->getUserDataByID($id);
		$this->viewData['documentdata'] = $this->User->getUserDocuemnts($id);
		$this->viewData['bankaccountdata'] = $this->User->getKitchenBankAccounts($id);
		
        $this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function change_password(){
		$this->viewData['title'] = "Change Password";
		$this->viewData['module'] = "user/Change_password";
		
		$this->admin_headerlib->add_javascript("user","pages/change_password.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function update_password(){
		$PostData = $this->input->post();
		//print_r($PostData);exit;

		$userid = $this->session->userdata(base_url().'USERID');
		$this->User->_table = 'admin';
		$this->User->_fields = "id,password";
		$this->User->_where = "id=".$userid;
		$UserData = $this->User->getRecordsByID();

		if(!empty($UserData)){

			if($PostData['password']==$UserData['password']){

				$updatedata = array('password'=>$PostData['newpassword']);
				
				$this->User->_table = 'admin';
				$this->User->_where = "id=".$userid;
				$this->User->Edit($updatedata);
				echo 1;
			}else{
				echo 2;
			}

		}else{
			echo 0;
		}
	}
	public function edit_profile(){
		$this->viewData['title'] = "Edit Profile";
		$this->viewData['module'] = "user/Edit_profile";
		$this->viewData['action'] = "1";

		$id = $this->session->userdata(base_url().'USERID');
		$this->viewData['userdata'] = $this->User->getAdminDataByID($id);

		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function update_profile(){
		/*
		0 - User not updated
		1 - User successfully updated
		2 - User email or mobile duplicated
		3 - User profile image not uplodaded
		4 - Invalid user profile image type
		*/
		$PostData = $this->input->post();

		$UserID = trim($PostData['userid']);
		$firstname = trim($PostData['firstname']);
		$lastname = trim($PostData['lastname']);
		$email = trim($PostData['email']);
		$mobileno = trim($PostData['mobileno']);
		$modifieddate = $this->general_model->getCurrentDateTime();
		$modifiedby = $this->session->userdata(base_url().'ADMINID');
		$oldprofileimage = trim($PostData['oldprofileimage']);
		$removeoldImage = trim($PostData['removeoldImage']);

		if($_FILES["image"]['name'] != ''){

			$image = reuploadfile('image', 'PROFILE', $oldprofileimage, PROFILE_PATH, "jpeg|png|jpg|JPEG|PNG|JPG", '', 1);
			if($image !== 0){
				if($image==2){
					echo 3;//image not uploaded
					exit;
				}
			}else{
				echo 4;//invalid image type
				exit;
			}	
		}else if($_FILES["image"]['name'] == '' && $oldprofileimage !='' && $removeoldImage=='1'){
			unlinkfile($oldprofileimage, PROFILE_PATH);
			$image = '';
		}else if($_FILES["image"]['name'] == '' && $oldprofileimage ==''){
			$image = '';
		}else{
			$image = $oldprofileimage;
		}
		$updatedata = array("firstname"=>$firstname,
							"lastname"=>$lastname,
							"image"=>$image,
							"email"=>$email,
							"mobileno"=>$mobileno,
							"modifieddate"=>$modifieddate,
							"modifiedby"=>$modifiedby);

		$this->User->_table = 'admin';
		$this->User->_where = array("id"=>$UserID);
		$this->User->Edit($updatedata);

		$userdata = array(
			base_url().'USERNAME' => $firstname." ".$lastname,
			base_url().'USEREMAIL' => $email,
			base_url().'USERPROFILE' => $image
		);
		$this->session->set_userdata($userdata);

		echo 1;
	}
	public function delete_user(){
		$PostData = $this->input->post();
		$ids = explode(",",$PostData['ids']);
		$count = 0;
		foreach($ids as $row){
			
			$this->User->_table = "user";
			$this->User->_fields = "id,menufile";
			$this->User->_where = "id=$row";
			$UserData = $this->User->getRecordsByID();

			if(!empty($UserData['menufile'])){
				unlinkfile($UserData['menufile'], MENU_PATH);
			}
			$this->User->_table = "userdocuments";
			$this->User->_fields = "id,file";
			$this->User->_where = "userid=$row";
			$DocData = $this->User->getRecordByID();

			if(!empty($DocData)){
				foreach($DocData as $doc){
					unlinkfile($doc['file'], DOCUMENT_PATH);
				}
			}
			$this->User->_table = "user";
			$this->User->Delete(array('id'=>$row));
		}
	}
	public function update_status(){
		$PostData = $this->input->post();
        $modifieddate = $this->general_model->getCurrentDateTime();
        
        $id = $PostData['id'];
        $userstatus = $PostData['userstatus'];
        
        $updateData = array(
            'userstatus'=>$userstatus,
            'modifieddate' => $modifieddate
        );  
       
        $this->User->_where = array("id" => $id);
        $this->User->Edit($updateData);

        echo 1;
	}
}