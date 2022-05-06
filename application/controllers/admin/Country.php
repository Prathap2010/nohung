<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends Admin_Controller {

	public $viewData = array();
	function __construct(){
		parent::__construct();
		$this->viewData = $this->getUserSettings("Country");
		$this->load->model('Country_model','Country');
	}
	public function index(){

		$this->viewData['title'] = "Region / Area";
		$this->viewData['module'] = "country/Country";

		$this->viewData['countrydata'] = $this->Country->getCountryData();
		
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function add_country() {

		$this->viewData['title'] = "Add Region / Area";
		$this->viewData['module'] = "country/Add_country";

		$this->admin_headerlib->add_javascript("add_country","pages/add_country.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);

	}
	public function country_add(){

		$PostData = $this->input->post();
       
		$countryname = trim($PostData['countryname']);
		$sortname = trim($PostData['sortname']);
		$phonecode = trim($PostData['phonecode']);
		$createddate = $this->general_model->getCurrentDateTime();
		
		$this->Country->_where = "name='".$countryname."'";
		$Count = $this->Country->CountRecords();

		if($Count==0){
        	
			$insertdata = array("name"=>$countryname,
								"sortname"=>$sortname,
								"phonecode"=>$phonecode,
								"createddate"=>$createddate
							);
			
			$Add = $this->Country->Add($insertdata);
			
			if($Add){
			    echo 1;
			}else{
				echo 0;
			}
        }else{
        	echo 2;
        }
	}
	public function edit_country($id){
		
		$this->viewData['title'] = "Edit Region / Area";
		$this->viewData['module'] = "country/Add_country";
		$this->viewData['action'] = "1";

		$this->viewData['countrydata'] = $this->Country->getCountryDataByID($id);

		$this->admin_headerlib->add_javascript("add_country","pages/add_country.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
	public function update_country(){
		
		$PostData = $this->input->post();
		$countryid = trim($PostData['countryid']);
		$countryname = trim($PostData['countryname']);
		$sortname = trim($PostData['sortname']);
		$phonecode = trim($PostData['phonecode']);
		$modifieddate = $this->general_model->getCurrentDateTime();
		
		$this->Country->_where = "id<>'".$countryid."' AND name='".$countryname."'";
		$Count = $this->Country->CountRecords();

		if($Count==0){

        	$updatedata = array("name"=>$countryname,
								"sortname"=>$sortname,
								"phonecode"=>$phonecode,
								"modifieddate"=>$modifieddate
							);

			$this->Country->_where = array("id"=>$countryid);
			$this->Country->Edit($updatedata);
			echo 1;
        }else{
        	echo 2;//STAFF EMAIL OR MOBILE DUPLICATE
        }
	}
	
	public function delete_country(){
		$PostData = $this->input->post();
		$ids = explode(",",$PostData['ids']);
		
		foreach($ids as $row){
    		$this->Country->Delete(array('id'=>$row));
		}
	}
}