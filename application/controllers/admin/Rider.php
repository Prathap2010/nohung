<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rider extends Admin_Controller {

	public $viewData = array();
	function __construct(){
		parent::__construct();
		$this->viewData = $this->getUserSettings("Rider");
		$this->load->model('Rider_model','Rider');
	}
	public function index(){

		$this->viewData['title'] = "Rider";
		$this->viewData['module'] = "rider/Rider";
		
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function get_rider_list() {

        $list = $this->Rider->get_datatables();
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
			$row[] = $datarow->email;
			$row[] = $datarow->mobilenumber;
			$row[] = $datarow->city;
			$row[] = $userstatus;
		    
			$Action .= '<a href="'.ADMIN_URL.'rider/view-rider/'.$datarow->id.'" class="'.view_class.'" title="'.view_title.'">'.view_text.'</a>';
			$Action .= '<a href="'.ADMIN_URL.'rider/edit-rider/'.$datarow->id.'" class="'.edit_class.'" title="'.edit_title.'">'.edit_text.'</a>';
			$Action .= '<a class="'.delete_class.'" href="javascript:void(0)" title="'.delete_title.'" onclick="deleterow('.$datarow->id.',\''.ADMIN_URL.'rider/delete-rider\')">'.delete_text.'</a>';
			if($datarow->status==1){ 
				$Action .= '<span id="span'.$datarow->id.'"><a href="javascript:void(0)" onclick="enabledisable(0,'.$datarow->id.',&quot;'.ADMIN_URL.'rider/rider-enable-disable&quot;,&quot;'.disable_title.'&quot;,&quot;'.disable_class.'&quot;,&quot;'.enable_class.'&quot;,&quot;'.disable_title.'&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_text.'&quot;,&quot;'.enable_text.'&quot;)" class="'.disable_class.'" title="'.disable_title.'">'.stripslashes(disable_text).'</a></span>';
			}else{
				$Action .= '<span id="span'.$datarow->id.'"><a href="javascript:void(0)" onclick="enabledisable(1,'.$datarow->id.',&quot;'.ADMIN_URL.'rider/rider-enable-disable&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_class.'&quot;,&quot;'.enable_class.'&quot;,&quot;'.disable_title.'&quot;,&quot;'.enable_title.'&quot;,&quot;'.disable_text.'&quot;,&quot;'.enable_text.'&quot;)" class="'.enable_class.'" title="'.enable_title.'">'.stripslashes(enable_text).'</a></span>';
			} 

            $row[] = $Action;
            $data[] = $row;

        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Rider->count_all(),
                        "recordsFiltered" => $this->Rider->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);        
    }
	public function edit_rider($id){
		
		$this->viewData['title'] = "Edit Rider";
		$this->viewData['module'] = "rider/Edit_rider";
		$this->viewData['action'] = "1";

		$this->viewData['riderdata'] = $this->Rider->getRiderDataByID($id);
				
		$this->load->model("City_model","City");
        $this->viewData['citydata'] = $this->City->getCityData(array("stateid IN (SELECT id FROM province WHERE countryid=101)"=>null),array("name"=>"ASC"));

		$this->admin_headerlib->add_javascript("edit_rider","pages/edit_rider.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function update_rider(){
		
		$PostData = $this->input->post();
		$RiderID = trim($PostData['riderid']);
		$ridername = trim($PostData['ridername']);
		$email = trim($PostData['email']);
        $mobilenumber = trim($PostData['mobilenumber']);
		$cityid = trim($PostData['city']);
		$biketype = trim($PostData['biketype']);
		$youhavelicense = trim($PostData['youhavelicense']);
		$oldlicencefile = trim($PostData['oldlicencefile']);
		$oldrcbookfile = trim($PostData['oldrcbookfile']);
		$oldpassportfile = trim($PostData['oldpassportfile']);
		$oldidprooffile = trim($PostData['oldidprooffile']);
		
        $status = trim($PostData['status']);
		
		$modifieddate = $this->general_model->getCurrentDateTime();
		
		$Check = $this->Rider->CheckEmailAvailable($email,$RiderID);
        
        if (empty($Check)) {
            
            $Check = $this->Rider->CheckMobileNumberAvailable($mobilenumber,$RiderID);

            if (empty($Check)) {

				if(!is_dir(DOCUMENT_PATH)){
                    @mkdir(DOCUMENT_PATH);
                }
				$licencefile = $oldlicencefile;
				if(isset($_FILES['licencefile']['name']) && $_FILES['licencefile']['name']!=""){
					if(!empty($oldlicencefile)){
						$licencefile = reuploadFile('licencefile', 'IMG&PDF', $oldlicencefile, DOCUMENT_PATH ,"*", '', 0);
					}else{
						$licencefile = uploadFile('licencefile', 'IMG&PDF' ,DOCUMENT_PATH ,"*", '', 0);
					}
					if($licencefile !== 0){	
						if ($licencefile == 2) {
							echo "Licence file not uploaded !";//FILE NOT UPLOADED
							exit;
						}
					}else{
						echo "Invalid licence file type !";//INVALID FILE TYPE
						exit;
					}
				}
				$rcbookfile = $oldrcbookfile;
				if(isset($_FILES['rcbookfile']['name']) && $_FILES['rcbookfile']['name']!=""){
					if(!empty($oldrcbookfile)){
						$rcbookfile = reuploadFile('rcbookfile', 'IMG&PDF', $oldrcbookfile, DOCUMENT_PATH ,"*", '', 0);
					}else{
						$rcbookfile = uploadFile('rcbookfile', 'IMG&PDF' ,DOCUMENT_PATH ,"*", '', 0);
					}
					if($rcbookfile !== 0){	
						if ($rcbookfile == 2) {
							echo "RC Book file not uploaded !";//FILE NOT UPLOADED
							exit;
						}
					}else{
						echo "Invalid RC Book file type !";//INVALID FILE TYPE
						exit;
					}
				}
				$passportfile = $oldpassportfile;
				if(isset($_FILES['passportfile']['name']) && $_FILES['passportfile']['name']!=""){
					if(!empty($oldpassportfile)){
						$passportfile = reuploadFile('passportfile', 'IMG&PDF', $oldpassportfile, DOCUMENT_PATH ,"*", '', 0);
					}else{
						$passportfile = uploadFile('passportfile', 'IMG&PDF' ,DOCUMENT_PATH ,"*", '', 0);
					}
					if($passportfile !== 0){	
						if ($passportfile == 2) {
							echo "Passport file not uploaded !";//FILE NOT UPLOADED
							exit;
						}
					}else{
						echo "Invalid Passport file type !";//INVALID FILE TYPE
						exit;
					}
				}
				$idprooffile = $oldidprooffile;
				if(isset($_FILES['idprooffile']['name']) && $_FILES['idprooffile']['name']!=""){
					if(!empty($oldidprooffile)){
						$idprooffile = reuploadFile('idprooffile', 'IMG&PDF', $oldidprooffile, DOCUMENT_PATH ,"*", '', 0);
					}else{
						$idprooffile = uploadFile('idprooffile', 'IMG&PDF' ,DOCUMENT_PATH ,"*", '', 0);
					}
					if($idprooffile !== 0){	
						if ($idprooffile == 2) {
							echo "ID Proof file not uploaded !";//FILE NOT UPLOADED
							exit;
						}
					}else{
						echo "Invalid ID Proof file type !";//INVALID FILE TYPE
						exit;
					}
				}
				
                $updatedata = array("kitchenname"	=> $ridername,
                                    "email"			=> $email,
                                    "mobilenumber"	=> $mobilenumber,
									"cityid"		=> $cityid,
									"biketype"		=> $biketype,
									"youhavelicense"=> $youhavelicense,
									"licencefile"	=> $licencefile,
									"rcbookfile"	=> $rcbookfile,
									"passportfile"	=> $passportfile,
									"idprooffile"	=> $idprooffile,
                                    "status"		=> $status,
                                    "modifieddate"	=> $modifieddate
                                );

                $this->Rider->_where = array("id"=>$RiderID);
                $this->Rider->Edit($updatedata);

                echo 1;
            }else{
                echo 3;
            }
		}else{
			echo 2;
		}
	}
	public function rider_enable_disable(){
		$val = (isset($_REQUEST['val']))?$_REQUEST['val']:'';
		$id = (isset($_REQUEST['id']))?$_REQUEST['id']:'';
		$updatedata = array('status'=>$val);
		$this->Rider->_where = "id=".$id;
		$result=$this->Rider->Edit($updatedata);
		if($result){
			echo $id;
		}
	}
	public function view_rider($id){

		$this->viewData['title'] = "View Rider";
        $this->viewData['module'] = "rider/View_rider";

        $this->viewData['riderdata'] = $this->Rider->getRiderDataByID($id);
		
        $this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function delete_rider(){
		$PostData = $this->input->post();
		$ids = explode(",",$PostData['ids']);
		
		foreach($ids as $row){
			
			
			$this->Rider->Delete(array('id'=>$row));
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
       
        $this->Rider->_where = array("id" => $id);
        $this->Rider->Edit($updateData);

        echo 1;
	}
}