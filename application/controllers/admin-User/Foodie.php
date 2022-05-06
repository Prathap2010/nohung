<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foodie extends Admin_Controller {

	public $viewData = array();
	function __construct(){
		parent::__construct();
		$this->viewData = $this->getUserSettings("Foodie");
		$this->load->model('Foodie_model','Foodie');
	}
	public function index(){

		$this->viewData['title'] = "Foodie";
		$this->viewData['module'] = "foodie/Foodie";
		
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function get_foodie_list() {

        $list = $this->Foodie->get_datatables();
        $data = array();
        $counter = $_POST['start'];
        
        foreach ($list as $datarow) {
            $row = array();
            $Action = '';
			$userstatus = "";
            
			/* if($datarow->userstatus==0){
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
			
			$userstatus = '<div class="dropdown" style="float: left;">'.$userstatus.'</div>'; */
			
			$row[] = ++$counter;            
            $row[] = ($datarow->kitchenname!="")?$datarow->kitchenname:"-";
			$row[] = ($datarow->email!="")?$datarow->email:"-";
			$row[] = $datarow->mobilenumber;
			
			if($datarow->profile_image!="" && file_exists(USER_PROFILE_PATH.$datarow->profile_image)){
				$row[] = "<img src='".USER_PROFILE.$datarow->profile_image."' class='thumbwidth'>";
			}else{
				$row[] = "<img src='".NOPROFILEIMAGE."' class='thumbwidth'>";
			}
		    // $row[] = $userstatus;
			$Action .= '<a href="'.ADMIN_URL.'foodie/edit-foodie/'.$datarow->id.'" class="'.edit_class.'" title="'.edit_title.'">'.edit_text.'</a>';
			$Action .= '<a class="'.delete_class.'" href="javascript:void(0)" title="'.delete_title.'" onclick="deleterow('.$datarow->id.',\''.ADMIN_URL.'foodie/delete-foodie\')">'.delete_text.'</a>';
			if($datarow->status==1){ 
				$Action .= '<span id="span'.$datarow->id.'"><a href="javascript:void(0)" onclick="enabledisable(0,'.$datarow->id.',&quot;'.ADMIN_URL.'foodie/foodie-enable-disable&quot;,&quot;'.disable_title.'&quot;,&quot;'.disable_class.'&quot;,&quot;'.enable_class.'&quot;,&quot;'.disable_title.'&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_text.'&quot;,&quot;'.enable_text.'&quot;)" class="'.disable_class.'" title="'.disable_title.'">'.stripslashes(disable_text).'</a></span>';
			}else{
				$Action .= '<span id="span'.$datarow->id.'"><a href="javascript:void(0)" onclick="enabledisable(1,'.$datarow->id.',&quot;'.ADMIN_URL.'foodie/foodie-enable-disable&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_class.'&quot;,&quot;'.enable_class.'&quot;,&quot;'.disable_title.'&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_text.'&quot;,&quot;'.enable_text.'&quot;)" class="'.enable_class.'" title="'.enable_title.'">'.stripslashes(enable_text).'</a></span>';
			} 

            $row[] = $Action;
            $data[] = $row;

        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Foodie->count_all(),
                        "recordsFiltered" => $this->Foodie->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);        
    }
	public function edit_foodie($id){
		
		$this->viewData['title'] = "Edit Foodie";
		$this->viewData['module'] = "foodie/Edit_foodie";
		$this->viewData['action'] = "1";

		$this->viewData['foodiedata'] = $this->Foodie->getFoodieDataByID($id);
				
		$this->admin_headerlib->add_javascript("edit_foodie","pages/edit_foodie.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function update_foodie(){
		
		$PostData = $this->input->post();
		$FoodieID = trim($PostData['foodieid']);
		$foodiename = trim($PostData['foodiename']);
		$email = trim($PostData['email']);
        $mobilenumber = trim($PostData['mobilenumber']);
		$password = trim($PostData['password']);
        $status = trim($PostData['status']);
		$oldprofile_image = trim($PostData['oldprofile_image']);
		$modifieddate = $this->general_model->getCurrentDateTime();
		
		$Check = $this->Foodie->CheckEmailAvailable($email,$FoodieID);
        
        if (empty($Check)) {
            
            $Check = $this->Foodie->CheckMobileNumberAvailable($mobilenumber,$FoodieID);

            if (empty($Check)) {

				if(!is_dir(USER_PROFILE_PATH)){
					@mkdir(USER_PROFILE_PATH);
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
                $updatedata = array("kitchenname"=>$foodiename,
                                    "email"=>$email,
                                    "mobilenumber"=>$mobilenumber,
									"password"=>$password,
									"profile_image"=>$profile_image,
                                    "status"=>$status,
                                    "modifieddate"=>$modifieddate
                                );

                $this->Foodie->_where = array("id"=>$FoodieID);
                $this->Foodie->Edit($updatedata);

                echo 1;
            }else{
                echo 3;
            }
		}else{
			echo 2;
		}
	}
	public function foodie_enable_disable(){
		$val = (isset($_REQUEST['val']))?$_REQUEST['val']:'';
		$id = (isset($_REQUEST['id']))?$_REQUEST['id']:'';
		$updatedata = array('status'=>$val);
		$this->Foodie->_where = "id=".$id;
		$result=$this->Foodie->Edit($updatedata);
		if($result){
			echo $id;
		}
	}
	public function delete_foodie(){
		$PostData = $this->input->post();
		$ids = explode(",",$PostData['ids']);
		$count = 0;
		foreach($ids as $row){
			
			$this->Foodie->_table = "user";
			$this->Foodie->Delete(array('id'=>$row));
		}
	}
	/* public function update_status(){
		$PostData = $this->input->post();
        $modifieddate = $this->general_model->getCurrentDateTime();
        
        $id = $PostData['id'];
        $userstatus = $PostData['userstatus'];
        
        $updateData = array(
            'userstatus'=>$userstatus,
            'modifieddate' => $modifieddate
        );  
       
        $this->Foodie->_where = array("id" => $id);
        $this->Foodie->Edit($updateData);

        echo 1;
	} */
}