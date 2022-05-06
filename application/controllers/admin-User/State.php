<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends Admin_Controller {

	public $viewData = array();
	function __construct(){
		parent::__construct();
		$this->viewData = $this->getUserSettings("State");
		$this->load->model('Province_model','Province');
	}
	public function index(){

		$this->viewData['title'] = "State";
		$this->viewData['module'] = "State";

		$this->viewData['statedata'] = $this->Province->getProvinceData(array("countryid"=>"101"));
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function add_state() {

		$this->viewData['title'] = "Add State";
		$this->viewData['module'] = "Add_state";

		$this->load->view(ADMINFOLDER.'template',$this->viewData);

	}
	public function state_add(){

		$PostData = $this->input->post();
       
		$name = trim($PostData['name']);
		// $code = trim($PostData['code']);
		$createddate = $this->general_model->getCurrentDateTime();
		
		$this->Province->_where = "name='".$name."'";
		$Count = $this->Province->CountRecords();

		if($Count==0){
        	
			$insertdata = array("name"=>$name,
								"countryid"=>101,
								"createddate"=>$createddate,
								"modifieddate"=>$createddate
							);
			
			$Add = $this->Province->Add($insertdata);
			
			if($Add){
			    echo 1;
			}else{
				echo 0;
			}
        }else{
        	echo 2;
        }
	}
	public function edit_state($id){
		
		$this->viewData['title'] = "Edit State";
		$this->viewData['module'] = "Add_state";
		$this->viewData['action'] = "1";

		$this->viewData['statedata'] = $this->Province->getProvinceDataByID($id);

		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function update_state(){
		
		$PostData = $this->input->post();
		$stateid = trim($PostData['stateid']);
		$name = trim($PostData['name']);
		// $code = trim($PostData['code']);
		$modifieddate = $this->general_model->getCurrentDateTime();
		
		$this->Province->_where = "id<>'".$stateid."' AND name='".$name."'";
		$Count = $this->Province->CountRecords();

		if($Count==0){

        	$updatedata = array("name"=>$name,
                                "countryid"=>101,
								"modifieddate"=>$modifieddate
							);

			$this->Province->_where = array("id"=>$stateid);
			$this->Province->Edit($updatedata);
			echo 1;
        }else{
        	echo 2;
        }
	}
	
	public function delete_state(){
		$PostData = $this->input->post();
		$ids = explode(",",$PostData['ids']);
		
		foreach($ids as $row){
    		$this->Province->Delete(array('id'=>$row));
		}
	}
}