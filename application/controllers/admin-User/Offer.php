<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends Admin_Controller {

    public $viewData = array();
    public $Emailformattype ;

    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Offer');
        $this->load->model('Offer_model', 'Offer');
    }

    public function index() {
        
        $this->viewData['title'] = "Offer Management";
        $this->viewData['module'] = "offer/Offer";

        $this->viewData['offerdata'] = $this->Offer->getOfferListData(); 

        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }
    public function add_offer(){

		$this->viewData['title'] = "Add Offer";
        $this->viewData['module'] = "offer/Add_offer";

        $this->admin_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/bootstrap-datepicker.js");
		$this->admin_headerlib->add_javascript("offer","pages/add_offer.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
    
    public function offer_add() {

        $PostData = $this->input->post();
       
        $title = trim($PostData['title']);
        $offercode = trim($PostData['offercode']);
        $startdate = trim($PostData['startdate']);
        $enddate = trim($PostData['enddate']);
        $description = trim($PostData['description']);
        $discounttype = trim($PostData['discounttype']);
        $discount = trim($PostData['discount']);
        $createddate = $this->general_model->getCurrentDateTime();

        $CheckOffer = $this->Offer->CheckOfferAvailable($offercode);
        
        if ($CheckOffer != 0) {

            $insertdata = array(
                "title" => $title,
                "offercode" => $offercode,
                "startdate" => $this->general_model->convertdate($startdate),
                "enddate" => $this->general_model->convertdate($enddate),
                "description" => $description,
                "discounttype" => $discounttype,
                "discount" => $discount,
                "usertype" => 0,
                "addedby" => $this->session->userdata(base_url().'USERID'),
                "createddate" => $createddate,
                "modifieddate" => $createddate);
            
            $OfferID = $this->Offer->Add($insertdata);

            if ($OfferID) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 2;
        }
    }

    public function edit_offer($id) {
        $this->viewData['title'] = "Edit Offer";
        $this->viewData['module'] = "offer/Add_offer";
        $this->viewData['action'] = "1"; //Edit
        
        $this->Offer->_where = array('id' => $id);
        $this->viewData['offerdata'] = $this->Offer->getRecordsByID();
        
        $this->admin_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/bootstrap-datepicker.js");
        $this->admin_headerlib->add_javascript_plugins("bootstrap-datetimepickerjs","bootstrap-datetimepicker/bootstrap-datetimepicker.js");
        $this->admin_headerlib->add_javascript("offer", "pages/add_offer.js");
        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }

    public function update_offer() {

        $PostData = $this->input->post();

        $offerid = trim($PostData['offerid']);
        $title = trim($PostData['title']);
        $offercode = trim($PostData['offercode']);
        $startdate = trim($PostData['startdate']);
        $enddate = trim($PostData['enddate']);
        $description = trim($PostData['description']);
        $discounttype = trim($PostData['discounttype']);
        $discount = trim($PostData['discount']);
        $appliesto = trim($PostData['appliesto']);
        $minrequirement = trim($PostData['minrequirement']);
        $usagelimit = trim($PostData['usagelimit']);
        $starttime = trim(date("H:i:s",strtotime($PostData['starttime'])));
        $endtime = trim(date("H:i:s",strtotime($PostData['endtime'])));

        $CheckOffer = $this->Offer->CheckOfferAvailable($offercode,$offerid);
        
        if ($CheckOffer != 0) {
            
            $modifieddate = $this->general_model->getCurrentDateTime();

            $updatedata = array(
                "title" => $title,
                "offercode" => $offercode,
                "description" => $description,
                "discounttype" => $discounttype,
                "discount" => $discount,
                "appliesto" => $appliesto,
                "minrequirement" => $minrequirement,
                "usagelimit" => $usagelimit,
                "startdate" => $this->general_model->convertdate($startdate),
                "enddate" => $this->general_model->convertdate($enddate),
                "starttime" => $starttime,
                "endtime" => $endtime,
                "modifieddate" => $modifieddate);

            $this->Offer->_where = array('id' => $offerid);
            $this->Offer->Edit($updatedata);
                
            echo 1;
        } else {
            echo 2;
        }
    }

    public function delete_offer(){
        $PostData = $this->input->post();
        $ids = explode(",",$PostData['ids']);
        foreach($ids as $row){
            $this->Offer->Delete(array('id'=>$row));
        }
    }  
    public function view_offer($id){

		$this->viewData['title'] = "View Offer";
        $this->viewData['module'] = "offer/View_offer";

        $this->viewData['offerdata'] = $this->Offer->getOfferDataByID($id);

        $this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
}

?>