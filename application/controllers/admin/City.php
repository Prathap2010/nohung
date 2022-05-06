<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends Admin_Controller {

	public $viewData = array();
	function __construct(){
		parent::__construct();
		$this->viewData = $this->getUserSettings("City");
		$this->load->model('City_model','City');
	}
	public function index(){

		$this->viewData['title'] = "City";
		$this->viewData['module'] = "City";

		$this->viewData['citydata'] = $this->City->getCityData(array("c.stateid IN (select id FROM province where countryid=101)"=>null));
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function add_city() {

		$this->viewData['title'] = "Add City";
		$this->viewData['module'] = "Add_city";

		$this->load->model('Province_model','Province');
		$this->viewData['provincedata'] = $this->Province->getProvinceData(array("countryid"=>"101"),array("name"=>"ASC"));

		$this->load->view(ADMINFOLDER.'template',$this->viewData);

	}
	public function city_add(){

		$PostData = $this->input->post();
       
		$name = trim($PostData['name']);
		$stateid = trim($PostData['state']);
		$createddate = $this->general_model->getCurrentDateTime();
		
		$this->City->_where = "name='".$name."'";
		$Count = $this->City->CountRecords();

		if($Count==0){
        	
			$insertdata = array("name"=>$name,
								"stateid"=>$stateid,
								"createddate"=>$createddate,
								"modifieddate"=>$createddate
							);
			
			$Add = $this->City->Add($insertdata);
			
			if($Add){
			    echo 1;
			}else{
				echo 0;
			}
        }else{
        	echo 2;
        }
	}
	public function edit_city($id){
		
		$this->viewData['title'] = "Edit City";
		$this->viewData['module'] = "Add_city";
		$this->viewData['action'] = "1";

		$this->viewData['citydata'] = $this->City->getCityDataByID($id);

		$this->load->model('Province_model','Province');
		$this->viewData['provincedata'] = $this->Province->getProvinceData(array("countryid"=>"101"),array("name"=>"ASC"));

		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function update_city(){
		
		$PostData = $this->input->post();
		$cityid = trim($PostData['cityid']);
		$name = trim($PostData['name']);
		$stateid = trim($PostData['state']);
		$modifieddate = $this->general_model->getCurrentDateTime();
		
		$this->City->_where = "id<>'".$cityid."' AND name='".$name."'";
		$Count = $this->City->CountRecords();

		if($Count==0){

        	$updatedata = array("name"=>$name,
								"stateid"=>$stateid,
								"modifieddate"=>$modifieddate
							);

			$this->City->_where = array("id"=>$cityid);
			$this->City->Edit($updatedata);
			echo 1;
        }else{
        	echo 2;
        }
	}
	
	public function delete_city(){
		$PostData = $this->input->post();
		$ids = explode(",",$PostData['ids']);
		
		foreach($ids as $row){
    		$this->City->Delete(array('id'=>$row));
		}
	}

    public function getCityData(){
		$PostData = $this->input->post();
  
        $cities = $this->City->getCityByProvince($PostData['provinceid']);
		echo json_encode($cities);
	}
}